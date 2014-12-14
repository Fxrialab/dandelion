/*global module:false*/
module.exports = function (grunt) {
    require('jit-grunt')(grunt);

    // Project configuration.
    grunt.initConfig({
        // Metadata.
        pkg: grunt.file.readJSON('package.json'),
        phpdocumentor: {
            api: {
                options: {
                    directory: 'vendors/fxrialab/',
                    target: 'gen-docs/api/'
                }
            }
        },
        markdown: {
            all: {
                files: [{
                        expand: true,
                        src: 'docs/*.md',
                        dest: 'gen-docs/',
                        ext: '.html'
                    }]
            }
        },
        gitbook: {
            docs: {
                output: 'gen-docs/',
                input: "docs/",
                title: "Developers' Guide"
            }
        }

    });

    // Default task.
    grunt.registerTask('gen-docs', ['gitbook','phpdocumentor']);
    grunt.registerTask('default','gen-docs');
};