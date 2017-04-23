var gulp = require('gulp');

// Default task chain: build -> (livereload or browsersync) -> watch
gulp.task('default', ['browsersync', 'watch']);

// Build a working copy of the theme
gulp.task('release', ['images', 'scripts', 'styles', 'theme']);

// Compress images - NOTE: this is a resource-intensive task!
gulp.task('optimize', ['images-optimize']);

// Tests - Lints
gulp.task('tests', () => {
    runSequence('sass-lint', 'css-lint', 'js-lint', 'php-lint', 'textdomain-lint');
});

gulp.task('release', () => {
    gutil.env.prod = true;
    gutil.env.disableMaps = true;
    runSequence('sass-theme', 'sass-core', 'sass-admin');
});
