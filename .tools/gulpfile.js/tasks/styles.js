var gulp          = require('gulp'),
    gutil         = require('gulp-util'),
    plugins       = require('gulp-load-plugins')({ camelize: true }),
    config        = require('../../gulpconfig').styles,
    autoprefixer  = require('autoprefixer'),
    processors    = [autoprefixer(config.autoprefixer)],
    browsersync   = require('browser-sync'),
    onError       = plugins.notify.onError("Error: <%= error.message %>")
;

// Lint SASS source files
gulp.task('sass-lint', () => {
    return gulp.src([config.sassLint.theme,config.sassLint.core,config.sassLint.admin])
        .pipe(plugins.sassLint())
        .pipe(plugins.sassLint.format());
});

// Lint CSS source files
gulp.task('css-lint', () => {
    return gulp.src([config.lint.theme, config.lint.core, config.lint.admin])
        .pipe(plugins.ignore.exclude(config.lint.ignore))
        .pipe(plugins.stylelint(config.lint.options))
        .pipe(plugins.logger({
            afterEach : ' - CSS Lint finished'
        }));;
});

// Build SCSS source files from `theme`
gulp.task('sass-theme', () => {
    return gulp.src(config.theme.src)
        .pipe(plugins.plumber({ errorHandler: onError }))
        .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.init()))
        .pipe(plugins.if(gutil.env.debug, plugins.sass({
            outputStyle: 'expanded',
            sourceComments: true
        })))
        .pipe(plugins.if(!gutil.env.debug, plugins.sass()))
        .pipe(plugins.sass(config.sass))
        .pipe(plugins.postcss(processors))
        .pipe(plugins.if(gutil.env.prod, plugins.cssnano(config.minify.options)))
        .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.write('./')))
        .pipe(gulp.dest(config.theme.dest))
        .pipe(plugins.logger({ afterEach: ' Compiled!' }))
        .pipe(browsersync.stream());
});

// Build SCSS source files from `core`
gulp.task('sass-core', () => {
    return gulp.src(config.core.src)
        .pipe(plugins.plumber({ errorHandler: onError }))
        .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.init()))
        .pipe(plugins.if(gutil.env.debug, plugins.sass({
            outputStyle: 'expanded',
            sourceComments: true
        })))
        .pipe(plugins.if(!gutil.env.debug, plugins.sass()))
        .pipe(plugins.postcss(processors))
        .pipe(plugins.if(gutil.env.prod, plugins.cssnano(config.minify.options)))
        .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.write('./')))
        .pipe(gulp.dest(config.core.dest))
        .pipe(plugins.logger({ afterEach: ' Compiled!' }))
        .pipe(browsersync.stream());
});

// Build SCSS source files from `admin`
gulp.task('sass-admin', () => {
    return gulp.src(config.admin.src)
        .pipe(plugins.plumber({ errorHandler: onError }))
        .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.init()))
        .pipe(plugins.if(gutil.env.debug, plugins.sass({
            outputStyle: 'expanded',
            sourceComments: true
        })))
        .pipe(plugins.if(!gutil.env.debug, plugins.sass()))
        .pipe(plugins.postcss(processors))
        .pipe(plugins.if(gutil.env.prod, plugins.cssnano(config.minify.options)))
        .pipe(plugins.if(config.sourcemaps, plugins.sourcemaps.write('./')))
        .pipe(gulp.dest(config.admin.dest))
        .pipe(plugins.logger({ afterEach: ' Compiled!' }))
        .pipe(browsersync.stream());
});

// Minify CSS theme files and copy to `build` folder
gulp.task('css-minify-theme', () => {
    return gulp.src(config.minify.theme.src)
        .pipe(plugins.ignore.exclude(config.minify.ignore))
        .pipe(plugins.cssnano(config.minify.options))
        .pipe(plugins.rename({ suffix: '.min' }))
        .pipe(plugins.changed(config.minify.theme.dest))
        .pipe(gulp.dest(config.minify.theme.dest));
});

// Minify CSS core files and copy to `build` folder
gulp.task('css-minify-core', () => {
    return gulp.src(config.minify.core.src)
        .pipe(plugins.ignore.exclude(config.minify.ignore))
        .pipe(plugins.cssnano(config.minify.options))
        .pipe(plugins.rename({ suffix: '.min' }))
        .pipe(plugins.changed(config.minify.core.dest))
        .pipe(gulp.dest(config.minify.core.dest));
});

// Minify CSS admin files and copy to `build` folder
gulp.task('css-minify-admin', () => {
    return gulp.src(config.minify.admin.src)
        .pipe(plugins.ignore.exclude(config.minify.ignore))
        .pipe(plugins.cssnano(config.minify.options))
        .pipe(plugins.rename({ suffix: '.min' }))
        .pipe(plugins.changed(config.minify.admin.dest))
        .pipe(gulp.dest(config.minify.admin.dest));
});

// Copy CSS source files to the `build` folder
gulp.task('styles-build', () => {
    return gulp.src(config.src)
        .pipe(plugins.changed(config.dest))
        .pipe(gulp.dest(config.dest));
});

// Master styles tasks
gulp.task('sass',       ['sass-theme', 'sass-core', 'sass-admin']);
gulp.task('css-minify', ['css-minify-theme', 'css-minify-core', 'css-minify-admin']);
gulp.task('styles',     ['styles-build', 'css-minify']);
