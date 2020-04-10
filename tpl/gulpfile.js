let gulp = require('gulp');
let gulpLoadPlugins = require('gulp-load-plugins');
let spritesmith = require('gulp.spritesmith');

let $ = gulpLoadPlugins();

let webpack = require('webpack');
let webpackStream = require('webpack-stream');

let merge = require('merge-stream');
let mergeJson = require('gulp-merge-json');
let runSequence = require('run-sequence');
let browserSync = require('browser-sync').create();

let reload = browserSync.reload;

let fs = require('fs');
let path = require('path');
let wait = require('gulp-wait');

let dev = true;
let assetPath = 'assets';
let config = {
    src: {
        css: `app/${assetPath}/css/app.scss`,
        js: `app/${assetPath}/js/*.js`,
        fonts: `app/${assetPath}/fonts/*.ttf`
    },
    tmp: {
        css: `.tmp/${assetPath}/css`,
        js: `.tmp/${assetPath}/js`,
        fonts: `.tmp/${assetPath}/fonts`
    },
    dist: {
        css: `dist/${assetPath}/css`,
        js: `dist/${assetPath}/js`,
        fonts: `dist/${assetPath}/fonts`,
        img: `dist/${assetPath}/images`
    },
};
let fileNameWatch = '*';
const rename = require('gulp-rename');
const replace = require('gulp-replace');
let tap = require('gulp-tap');
const readlineSync = require('readline-sync');
let image = require('gulp-image');

// get base folder
let gulpRanInThisFolder = process.cwd();
let baseArray = gulpRanInThisFolder.split("\\");
let baseFolder = gulpRanInThisFolder+'/app';

gulp.task('css', () => gulp.src([config.src.css, 'source/assets/css/**.scss', '!source/assets/css/**/_*.[scss|sass'])
    .pipe(wait(500))
    .pipe($.plumber({ errorHandler: $.notify.onError('Error: <%= error.message %>') }))
    .pipe($.if(dev, $.sourcemaps.init()))
    .pipe($.sassGlob())
    .pipe($.sass.sync({
        outputStyle: 'expanded',
        precision: 10,
        includePaths: ['.', 'node_modules'],
    }).on('error', $.sass.logError))
    .pipe($.autoprefixer({ browsers: ['> 1%', 'last 5 versions', 'Firefox ESR'] }))
    .pipe($.if(dev, $.sourcemaps.write('.'), $.cssnano({ safe: true, autoprefixer: false })))
    .pipe($.if(dev, gulp.dest(config.tmp.css), gulp.dest(config.dist.css)))
    .pipe($.plumber.stop())
    .pipe(reload({ stream: true })));

gulp.task('build:css', () => {
    dev = false;
    gulp.start('css');
});

gulp.task('imagemin', () => gulp.src([
        `app/${assetPath}/images/**/*`,
        `!app/${assetPath}/images/sprites-retina`,
        `!app/${assetPath}/images/sprites`,
        `!app/${assetPath}/images/sprites-retina/**`,
        `!app/${assetPath}/images/sprites/**`,
    ])
    .pipe($.plumber({ errorHandler: $.notify.onError('Error: <%= error.message %>') }))
    .pipe(tap(function(file, t) {
        var distFilePath = file.path.replace('app','dist');
        //console.log(file.path);
        if (fs.existsSync(distFilePath)) {
            //console.log('exist');
        } else {
            // console.log('no-exist');
            // console.log(distFilePath.replace(gulpRanInThisFolder+'\\dist\\assets\\images\\',''));
            // console.log(path.dirname(file.path));
            return gulp.src(file.path)
            .pipe(image())
            .pipe(gulp.dest(config.dist.img + path.dirname(file.path).replace('app','dist').replace(gulpRanInThisFolder+'\\dist\\assets\\images','')))
        }
    }))
    //.pipe(image())
    //.pipe(gulp.dest(config.dist.img))
    .pipe($.plumber.stop()));
gulp.task('css-to-twig', function() {
    return gulp.src(config.dist.css+'/app.css')
        .pipe(replace('{#','{ #'))
        .pipe(replace('url(../', 'url({{ assets_url }}/'))
        .pipe(replace('url("../', 'url("{{ assets_url }}/'))
        .pipe(replace('url(\'../', 'url(\'{{ assets_url }}/'))
        .pipe(rename(function(path) {
            path.basename += "-compressed";
            path.extname = ".twig";
        }))
        .pipe(gulp.dest('app/assets/css/'))
});

gulp.task('js', () => gulp.src(config.src.js)
    .pipe($.plumber({
        errorHandler: $.notify.onError('Error: <%= error.message %>'),
    }))
    .pipe(webpackStream(require('./webpack.dev.js'), webpack))
    .pipe(gulp.dest(config.tmp.js))
    .pipe($.plumber.stop()));

gulp.task('js-watch', ['js-reload'], (done) => {
    browserSync.reload();
    done();
});

gulp.task('js-reload', () => gulp.src(config.src.js)
    .pipe($.plumber({
        errorHandler: $.notify.onError('Error: <%= error.message %>'),
    }))
    .pipe(webpackStream(require('./webpack.reload.js'), webpack))
    .pipe(gulp.dest(config.tmp.js))
    .pipe($.plumber.stop()));

gulp.task('build:js', () => gulp.src(config.src.js)
    .pipe($.plumber({
        errorHandler: $.notify.onError('Error: <%= error.message %>'),
    }))
    .pipe(webpackStream(require('./webpack.prod.js'), webpack))
    .pipe(gulp.dest(config.dist.js))
    .pipe($.plumber.stop()));

gulp.task('html', ['css', 'build:js'], () => {
    let indexTwig = gulp.src([
            'app/index.twig',
            `!app/${assetPath}/**`,
        ])
        .pipe($.data((file) => {
            return JSON.parse(fs.readFileSync('./app/_data/build/index.json', 'utf-8'));
        }))
        .pipe($.twig({
            base:baseFolder,
            // functions for backend
            functions:[
                {
                    name: "__",
                    func: function (string,theme) {
                        return string;
                    }
                },
                {
                    name: "parseFloat",
                    func: function (string) {
                        return parseFloat(string);
                    }
                }
            ],
            filters: [
                {
                    name: "resize",
                    func: function (value) {
                        return value;
                    }
                }
            ]
        }))
        .pipe($.useref({ searchPath: ['app', '.'] }))
        .pipe($.if('*.js', $.uglify()))
        .pipe($.if(/\.css$/, $.cssnano({ safe: true, autoprefixer: false })))
        .pipe(gulp.dest('dist'));

    let othersTwig = gulp.src([
            '!app/index.twig',
            'app/*.twig',
            `!app/${assetPath}/**`,
        ])
        .pipe(tap(function(file, t) {
            fileNameWatch = path.basename(file.path, '.twig');
        }))
        .pipe($.data((file) => {
            return JSON.parse(fs.readFileSync('./app/_data/build/'+fileNameWatch+'.json', 'utf-8'));
        }))
        .pipe($.twig({
            base:baseFolder,
            // functions for backend
            functions:[
                {
                    name: "__",
                    func: function (string,theme) {
                        return string;
                    }
                },
                {
                    name: "parseFloat",
                    func: function (string) {
                        return parseFloat(string);
                    }
                }
            ],
            filters: [
                {
                    name: "resize",
                    func: function (value) {
                        return value;
                    }
                }
            ]
        }))
        .pipe($.useref({
            noAssets: true,
            searchPath: ['app', '.'],
        }))
        .pipe(gulp.dest('dist'));

    return merge(indexTwig, othersTwig);
});

gulp.task('sprite', () => {
    let spriteData = gulp.src(`app/${assetPath}/images/sprites/*.png`).pipe(spritesmith({
        retinaSrcFilter: [`app/${assetPath}/images/sprites/*@2x.png`],
        imgName: '../images/sprites.png',
        retinaImgName: '../images/sprites@2x.png',
        cssName: '_sprites.scss',
    }));

    let imgStream = spriteData.img
        .pipe(gulp.dest(`app/${assetPath}/images/`));

    let cssStream = spriteData.css
        .pipe(gulp.dest(`app/${assetPath}/css/`));

    return merge(imgStream, cssStream);
});

gulp.task('images', () => gulp.src([
        `app/${assetPath}/images/**/*`,
        `!app/${assetPath}/images/sprites-retina`,
        `!app/${assetPath}/images/sprites`,
        `!app/${assetPath}/images/sprites-retina/**`,
        `!app/${assetPath}/images/sprites/**`,
    ])
    .pipe($.plumber({ errorHandler: $.notify.onError('Error: <%= error.message %>') }))
    .pipe(gulp.dest(config.dist.img))
    .pipe($.plumber.stop()));



gulp.task('fonts', () => {
    gulp.src(`app/${assetPath}/fonts/*.*`)
        .pipe($.if(dev, gulp.dest(`.tmp/${assetPath}/fonts/`), gulp.dest(`dist/${assetPath}/fonts/`)));
});

gulp.task('extras', () => {
    gulp.src([
        'app/*.*',
        '!app/**/*.twig',
        '!app/_templates',
        '!app/_templates/**',
        '!app/_data',
        '!app/_data/**',
    ], {
        dot: true,
    }).pipe(gulp.dest('dist'));
});

gulp.task('merge-json', () => gulp.src(['app/*.twig'])
    .pipe(tap(function(file, t) {
        fileNameWatch = path.basename(file.path, '.twig');
        // console.log(fileNameWatch);
        return gulp.src(['app/_data/global/*.json','app/_data/pages/'+ fileNameWatch +'.json'])
        .pipe(mergeJson({
            fileName: fileNameWatch+'.json',
            mergeArrays: false
        }))
        .pipe(gulp.dest('./app/_data/build/'));
    }))
);

gulp.task('twig', () => gulp.src('app/*.twig')
    .pipe($.plumber({ errorHandler: $.notify.onError('Error: <%= error.message %>') }))
    .pipe(tap(function(file, t) {
        fileNameWatch = path.basename(file.path, '.twig');
    }))
    .pipe($.data((file) => {
        return JSON.parse(fs.readFileSync('./app/_data/build/'+fileNameWatch+'.json', 'utf-8'));
    }))
    .pipe($.twig({
        base:baseFolder,
        // functions, filters for backend
        functions:[
            {
                name: "__",
                func: function (string,theme) {
                    return string;
                }
            },
            {
                name: "parseFloat",
                func: function (string) {
                    return parseFloat(string);
                }
            }
        ],
        filters: [
            {
                name: "resize",
                func: function (value) {
                    return value;
                }
            }
        ]
    }))
    .pipe(gulp.dest('.tmp/'))
    .pipe($.plumber.stop()));

gulp.task('twig-watch', () => {
    runSequence('merge-json','twig', () => {
        browserSync.reload();
    });
})

gulp.task('serve', () => {
    runSequence(['merge-json'], ['sprite', 'css', 'js', 'fonts'], ['twig'],() => {
        browserSync.init({
            notify: false,
            port: 9000,
            reloadDelay: 100,
            logLevel: 'info',
            online: true,
            open: 'external',
            server: {
                baseDir: ['.tmp', 'app'],
                directory: true,
                routes: {
                    '/node_modules': 'node_modules',
                },
            },
        });

        gulp.watch([
            `app/${assetPath}/images/**/*`,
            `.tmp/${assetPath}/fonts/**/*`,
        ]).on('change', reload);

        var watcher = gulp.watch(['app/**/*.twig', 'app/_components/*.twig', 'app/_data/pages/*.json', '!app/_data/build/*.json'], ['twig-watch']);
        // watcher.on('change', function(event) {
        //     if ( event.type === 'changed' ) {
        //         if (path.basename(event.path).indexOf('.twig') > -1) {
        //             fileNameWatch = path.basename(event.path, '.twig');
        //         }
        //
        //         if (path.basename(event.path).indexOf('.json') > -1) {
        //             fileNameWatch = path.basename(event.path, '.json');
        //         }
        //     }
        // });
        gulp.watch(`app/${assetPath}/images/sprites/*.png`, ['sprite']);
        gulp.watch(`app/${assetPath}/css/**/*.scss`, ['css']);
        gulp.watch(`app/${assetPath}/js/**/*.js`, ['js-watch']);
        gulp.watch(`app/${assetPath}/fonts/**/*`, ['fonts']);
    });
});

gulp.task('clean', () => gulp.src(['.tmp/', 'dist/'], { read: false })
    .pipe($.rimraf({
        force: true
    })));

gulp.task('cleanDist', () => gulp.src('dist/', { read: false })
    .pipe($.rimraf({
        force: true
    })));

gulp.task('build', () => {
    // dev = false;
    // runSequence(['sprite', 'merge-json', 'build:css', 'tinypng', 'fonts', 'extras'], ['css-to-twig', 'html'], () => gulp.src('dist/**/*'));
    var modifiedImage = readlineSync.question('Is there any modified image, y or n ? \r\n');
    if(modifiedImage == "y") {
        console.log('YES');
        runSequence('build-all');
    } else {
        console.log('NO');
        runSequence('build-normal');
    }
});

gulp.task('build-normal', () => {
    dev = false;
    runSequence(['sprite', 'merge-json', 'build:css', 'imagemin', 'fonts', 'extras'], ['css-to-twig', 'html'], () => gulp.src('dist/**/*'));
});

gulp.task('build-all', ['cleanDist'], () => {
    dev = false;
    runSequence(['sprite', 'merge-json', 'build:css', 'imagemin', 'fonts', 'extras'], ['css-to-twig', 'html'], () => gulp.src('dist/**/*'));
});

gulp.task('build-raw-img', () => {
    dev = false;
    runSequence(['sprite', 'merge-json', 'build:css', 'images', 'fonts', 'extras'], ['css-to-twig', 'html'], () => gulp.src('dist/**/*'));
});

gulp.task('default', ['clean'], () => {
    gulp.start('build');
});
