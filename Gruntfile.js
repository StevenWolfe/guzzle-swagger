module.exports = function (grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        composer: grunt.file.readJSON('composer.json'),
        watch: {
            options: {
                livereload: true
            },
            files: [
                'Gruntfile.js',
                'src/**/*.php'
            ],
            tasks: ['default']
        },
        phplint: {
            options: {
                swapPath: '/tmp'
            },
            library: [
                'src/**/*.php'
            ]
        },
        phpcs: {
            library: {
                dir: ['src']
            },
            options: {
                bin: 'vendor/bin/phpcs',
                standard: 'PSR2',
                extensions: 'php'
            }
        },
        phpunit: {
            classes: {
                dir: 'tests'
            },
            options: {
                bin: 'vendor/bin/phpunit',
                staticBackup: false,
                colors: true,
                noGlobalsBackup: false
            }
        },
        behat: {
            features: {
                options:{
                    output: true,
                    //failOnUndefined: false,
                    //failOnFailed: false
                },
                cmd: 'vendor/bin/behat',
                features: 'features/'
            }
        }
    });

    grunt.loadNpmTasks('grunt-phpunit');
    grunt.loadNpmTasks('grunt-phplint');
    grunt.loadNpmTasks('grunt-phpcs');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-behat');

    grunt.registerTask('default', ['phplint', 'phpcs', 'phpunit', 'behat']);
    grunt.registerTask('livereload', ['default', 'watch']);

};