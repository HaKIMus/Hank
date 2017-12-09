(function (r) {
    "use strict";
    var sass = r('gulp-sass'),
        nodemon = r("gulp-nodemon"),
        cleanCSS = r("gulp-clean-css"),
        cleanJS = r("gulp-minify"),
        rename = r("gulp-rename"),
        gulp = r("gulp");

    var pathToTheAssets = './public/assets';

    gulp.task('watch', function() {
        gulp.watch(pathToTheAssets + '/css/bootstrap.css', ['minify-bootstrap-css']);
        gulp.watch(pathToTheAssets + '/css/bootstrap-admin.css', ['minify-bootstrap-admin-css']);
        gulp.watch(pathToTheAssets + '/js/scripts.js', ['minify-js']);
        gulp.watch(pathToTheAssets + '/scss/*/*/*.scss', ['sass']);
        gulp.watch(pathToTheAssets + '/scss/*/*.scss', ['sass']);
        gulp.watch(pathToTheAssets + '/scss/*.scss', ['sass']);
        gulp.watch(pathToTheAssets + '/scss/bootstrap-admin.scss', ['sass-bootstrap-admin']);
        gulp.watch(pathToTheAssets + '/scss/admin/*/*.scss', ['sass-bootstrap-admin']);
        gulp.watch(pathToTheAssets + '/scss/admin/*.scss', ['sass-bootstrap-admin']);
    });

    gulp.task('sass-bootstrap-admin', function() {
        return gulp.src(pathToTheAssets + '/scss/bootstrap-admin.scss')
            .pipe(sass())
            .pipe(gulp.dest(pathToTheAssets + '/css'));
    });

    gulp.task('sass', function(){
        return gulp.src(pathToTheAssets + '/scss/bootstrap.scss')
            .pipe(sass())
            .pipe(gulp.dest(pathToTheAssets + '/css'))
    });

    gulp.task('minify-bootstrap-admin-css', function () {
        return gulp.src(pathToTheAssets + '/css/bootstrap-admin.css')
            .pipe(cleanCSS())
            .pipe(rename({suffix: '.min'}))
            .pipe(gulp.dest(pathToTheAssets + '/css'));
    });

    gulp.task('minify-bootstrap-css', function () {
        return gulp.src(pathToTheAssets + '/css/bootstrap.css')
            .pipe(cleanCSS())
            .pipe(rename({suffix: '.min'}))
            .pipe(gulp.dest(pathToTheAssets + '/css'));
    });

    gulp.task('minify-js', function() {
        return gulp.src(pathToTheAssets + '/js/scripts.js')
            .pipe(cleanJS({
                ext:{
                    //src: '.min.js',
                    min:'.min.js'
                },
                ignoreFiles: ['.combo.js', '*.min.js']
            }))
            .pipe(gulp.dest(pathToTheAssets + '/js'))
    });

    gulp.task('nodemon', function () {
        nodemon()
            .on('start', ['watch'], function () {
                console.log('start!');
            })
            .on('change', ['watch'], function () {
                console.log('change!');
            })
            .on('restart', function () {
                console.log('restarted!');
            });
    })
}(require));