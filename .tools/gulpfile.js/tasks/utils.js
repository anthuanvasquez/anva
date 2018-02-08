var gulp        = require('gulp'),
    plugins     = require('gulp-load-plugins')({ camelize: true }),
    del         = require('del'),
    config      = require('../../gulpconfig').utils
;

// Totally wipe the contents of the `dist` folder to prepare
gulp.task('wipe-dist', () => {
    return del(config.wipe.dist, { force: true });
});

// Totally wipe the contents of the `build` folder
gulp.task('wipe-build', () => {
    return del(config.wipe.build, { force: true });
});

// Clean out junk files after build
gulp.task('clean', ['wipe-dist'], () => {
    return del(config.clean, { force: true });
});

// Copy changed fonts from the source folder to `build`
gulp.task('fonts', () => {
    return gulp.src(config.fonts.src)
        .pipe(plugins.changed(config.fonts.dest))
        .pipe(gulp.dest(config.fonts.dest));
});

// Copy files from the `build` folder to `dist/[project-version]`
gulp.task('dist', ['clean'], () => {
    return gulp.src(config.dist.src)
        .pipe(plugins.zip(config.dist.name))
        .pipe(gulp.dest(config.dist.dest))
        .pipe(plugins.notify({ message: 'Distribution folder created' }));
});
