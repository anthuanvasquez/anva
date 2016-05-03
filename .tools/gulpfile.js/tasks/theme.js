// ==== THEME ==== //

var gulp        = require('gulp'),
    plugins     = require('gulp-load-plugins')({ camelize: true }),
    config      = require('../../gulpconfig').theme
;

// Copy PHP source files to the `build` folder
gulp.task('theme-php', function() {
  return gulp.src(config.php.src)
  .pipe(plugins.changed(config.php.dest))
  .pipe(gulp.dest(config.php.dest));
});

// Copy everything under `../languages` indiscriminately
gulp.task('theme-lang', function() {
  return gulp.src(config.lang.src)
  .pipe(plugins.changed(config.lang.dest))
  .pipe(gulp.dest(config.lang.dest));
});

// Make POT file for translation
gulp.task('theme-pot', function () {
  return gulp.src(config.php.src)
  .pipe(plugins.sort())
  .pipe(plugins.wpPot({
      domain: 'anva',
      destFile:'anva.pot',
      package: 'anva',
      bugReport: 'http://anthuanvasuqez.net',
      lastTranslator: 'Anthuan Vásquez <me@anthuanvasuqez.net>',
      team: 'Anthuan Vásquez <me@anthuanvasuqez.net>'
  }))
  .pipe(gulp.dest(config.lang.dest))
  .pipe(plugins.notify({ message: 'POT file created' }));
});

// Lint php files
gulp.task('php-lint', function(){
  return gulp.src(config.php.src)
    .pipe(plugins.phplint())
    .pipe(plugins.phplint.reporter(function(file){
      var report = file.phplintReport || {};
      if (report.error) {
        console.error(report.message+' on line '+report.line+' of '+report.filename);
      }
    }));
});

// All the theme tasks in one
gulp.task('theme', ['theme-lang', 'theme-php']);
