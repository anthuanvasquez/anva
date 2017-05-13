var gulp        = require('gulp'),
    plugins     = require('gulp-load-plugins')({ camelize: true }),
    config      = require('../../gulpconfig').watch,
    browsersync = require('browser-sync')
;

// Watch (BrowserSync version): build stuff when source files
// are modified, let BrowserSync figure out when to reload
gulp.task('watch', function() {
    gulp.watch(config.src.theme, ['sass-theme']);
    gulp.watch(config.src.core, ['sass-core']);
    gulp.watch(config.src.admin, ['sass-admin']);
    gulp.watch(config.src.scripts, browsersync.reload);
    gulp.watch(config.src.images, browsersync.reload);
    gulp.watch(config.src.php, browsersync.reload);
});
