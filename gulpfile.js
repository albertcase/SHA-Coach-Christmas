var gulp = require('gulp'),
    uglify = require('gulp-uglify'),
    minify = require('gulp-minify-css'),
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

gulp.task('script', function() {
    // 1. 找到文件
    gulp.src('js/*.js')
        // 2. 压缩文件
        .pipe(uglify())
        // 3. 另存压缩后的文件
        .pipe(gulp.dest('dist/js'))
});

gulp.task('css', function () {
    // 1. 找到文件
    gulp.src('css/*.css')
        // 2. 压缩文件
        .pipe(minify())
        // 3. 另存为压缩文件
        .pipe(gulp.dest('dist/css'));
});

// Default
gulp.task('default', ['browser-sync']);

gulp.task('uf', ['script','css']);