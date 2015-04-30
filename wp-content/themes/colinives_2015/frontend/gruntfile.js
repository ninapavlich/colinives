module.exports = function(grunt) {

    // 1. All configuration goes here 
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        compass: {
            dist: {
              options: {
                sassDir: "sass",
                cssDir: "compiled/compass/css",
                config: "config.rb"
              }
            },
        },

        concat_css: {
            options: {
              // Task-specific options go here. 
            },
            all: {
              src: ["css/*.css","css/vendor/*.css","compiled/compass/css/screen.css"],
              dest: "compiled/compass/css/screen.combined.css"
            },
        },

        cssmin: {
            minify: {
                expand: true,
                cwd: 'compiled/compass/css/',
                src: ['*.css','*.*.css', '!*.min.css'],
                dest: 'compiled/cssmin/css/',
                ext: '.min.css'
            }
        },

        

        concat: {   
            dist: {
                src: [
                    //Stuff we need from the get go
                    'js/shims/*.js', 
                    'js/vendor/*.js', 

                    //vendor libs
                    'bower_components/jquery-ui/jquery-ui.js', 
                    'bower_components/jquery-easing/jquery.easing.js', 
                    'bower_components/jquery-waypoints/waypoints.min.js',                    
                    'bower_components/jquery-touchswipe/jquery.touchSwipe.js', 
                    'bower_components/liquidslider/js/jquery.liquid-slider.min.js',                    
                    'bower_components/jquery-throttle-debounce/jquery.ba-throttle-debounce.min.js',
                    
                    //custom widgets
                    'js/widgets/*.js',

                    'js/colinives.js',
                    'js/bootstrap/*.js',
                ],
                dest: "compiled/concat/js/colinives.combined.js"
            }
        },

        uglify: {
            build: {
                files: {
                    'compiled/uglify/js/colinives.combined.min.js': ['compiled/concat/js/colinives.combined.js']
                }
            }
        },
        copy: {
            scripts: {
                files:[{
                    expand: true,
                    cwd: 'compiled/uglify/js/',
                    src: ['**/*'],
                    dest: '../js/'
                },
                {
                    expand: true,
                    cwd: 'compiled/concat/js/',
                    src: ['**/*'],
                    dest: '../js/'
                }]
            },
            styles: {
                files: [{
                    expand: true,
                    cwd: 'compiled/cssmin/css/',
                    src: ['**/*'],
                    dest: '../css/'

                },{
                    expand: true,
                    cwd: 'compiled/compass/css/',
                    src: ['**/*'],
                    dest: '../css/'

                }]
            }
        },  

        imagemin: {
            dynamic: {
                files: [{
                    expand: true,
                    cwd: '../img/',
                    src: ['**/*.{png,jpg,gif}'],
                    dest: '../img/' /* overwrites originals */
                }]
            }
        },

        watch: {
            scripts: {
                files: ['js/*.js', 'js/*/*.js'],
                tasks: ['concat', 'uglify', 'copy:scripts'],
                options: {
                    spawn: false
                },
            }, 
            
            css: {
                files: ['**/*.scss'],
                tasks: ['compass:dist', 'concat_css', 'cssmin:minify', 'copy:styles'],
                options: {
                    spawn: false
                }
            }
        }
    });

    // 3. Where we tell Grunt we plan to use this plug-in.
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-imagemin');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-cache-breaker');
    grunt.loadNpmTasks('grunt-concat-css');

    // 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
    /*grunt.registerTask(
        'default',
        [
            'concat',
            'uglify',
            'copy:scripts',
            'compass:dist',
            'cssmin:minify',
            'copy:styles'
        ]
    );*/
    grunt.registerTask(
        'default',
        [
            'concat',
            'copy:scripts',
            'compass:dist',
            'concat_css',
            'copy:styles',
            'watch'
        ]
    );
};
