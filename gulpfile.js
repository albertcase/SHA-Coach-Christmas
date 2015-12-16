var gulp = require('gulp'),
    uglify = require('gulp-uglify'),
    minify = require('gulp-minify-css'),
    concat = require('gulp-concat'),
    browserSync = require('browser-sync').create();

// Browser-sync
gulp.task('browser-sync', function() {
    browserSync.init({
        server: {
            baseDir: "./",
            startPath: '/index.html'
        }
    });
});

gulp.task('concatjqueryrem', function() {
    return gulp.src(['js/jquery.min.js','js/rem.js'])
        .pipe(concat('jrem.js'))
        .pipe(uglify())
        .pipe(gulp.dest('dist/js'));
});

gulp.task('concatscriptall', function() {
    return gulp.src(['js/pre-loader.js','js/marquee.js','js/service.js','js/wxshare.js','js/shake.js', 'js/common.js'])
        .pipe(concat('all.js'))
        .pipe(uglify())
        .pipe(gulp.dest('dist/js'));
});

gulp.task('css', function () {
    // 1. 找到文件
    gulp.src('css/*.css')
        .pipe(concat('style.css'))
        // 2. 压缩文件
        .pipe(minify())
        // 3. 另存为压缩文件
        .pipe(gulp.dest('dist'));
});

// Default
//gulp.task('default', ['browser-sync']);

gulp.task('uf', ['concatjqueryrem','concatscriptall','css']);