/**
 * Uppish
 *
 * JavaScripts responsible for adding/editing attachments.
 *
 * @package    laravel
 * @subpackage uppish
 */

var uppish = JSON.parse(uppish);

// Keep track of the 'required' fields.
$('.js-uppish[required]').addClass('uppish-required');

function isMimes(mimes) {
    var data = mimes.map(function (mime) {
        return mime.indexOf('/') > -1 ? true : false;
    });

    // All are true, then true, false otherwise.
    return data.indexOf(true) > -1 ? true : false;
}

function stringToArray(string) {
    var arr = string.split(',');

    // Remove white spaces from the values.
    arr = arr.map(function (extension) {
        return extension.trim();
    });

    return arr;
}

function sanitizeExtensions(extensions) {
    return exts = extensions.map(function (extension) {
        return extension.toString().split('.').join('');
    });
}

function isObject(string) {
    return typeof string === 'object' ? true : false;
}

function inputElem(attrName, fileName, file) {
    var publicFile = file;
    if (file.indexOf("public/") == 0) {
        // https://stackoverflow.com/a/37489832/1743124
        publicFile = "/storage/" + file.slice("public/".length);
    }

    return `
    <div class="js-uppish-uploaded-file position-relative my-1 clearfix">
        <input type="hidden" class="js-uppish-file" name="${attrName}" value="${file}">
        <a class="btn btn-block btn-info text-white text-left pr-5" href="${publicFile}" target="_blank" rel="noopener">
            ${fileName}
        </a>
        <button type="button" class="js-uppish-delete-file float-right btn rounded-pill" data-file="${file}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="align-top mr-1">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="9" y1="9" x2="15" y2="15"></line>
                <line x1="15" y1="9" x2="9" y2="15"></line>
            </svg>
            <span class="sr-only">Delete ${fileName}</span>
        </button>
    </div>
    `;
}

function isMultipleFiles(element) {
    var attribute = element.data('name');
    return attribute.includes('[]') || attribute.includes('[ ]') ? true : false;
}

function manageMandatoryField(element) {
    if (element.hasClass('uppish-required')) {
        var uploaded = element.parent('.btn-uppish').siblings('.uppish-uploads').find('.js-uppish-uploaded-file').length;
        if (isMultipleFiles(element)) {
            if (uploaded > 0) {
                element.removeAttr('required');
            } else {
                element.prop('required', true);
            }
        } else {
            if (uploaded > 0) {
                element.removeAttr('required');
            } else {
                element.prop('required', true);
            }
        }
    }
}

var app_url = '<?php echo baseUrl(); ?>';
jQuery(function($) {
    // https://stackoverflow.com/a/10811427/1743124
    var Upload = function (file) {
        this.file = file;
    };

    Upload.prototype.getType = function() {
        return this.file.type;
    };

    Upload.prototype.getSize = function() {
        return this.file.size;
    };

    Upload.prototype.getName = function() {
        return this.file.name;
    };

    // https://stackoverflow.com/a/4695156/1743124
    Upload.prototype.getExtension = function() {
        return this.file.name.split('.').pop();
    };

    Upload.prototype.doUpload = function (element) {
        var that      = this;
        var formData  = new FormData();
        var uploadBtn = element.parent('.btn-uppish');

        // add assoc key values, this will be posts values
        formData.append("file", this.file, this.getName());
        // formData.append("upload_file", true);

        var ajx = $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: uppish.routeUpload,
            xhr: function () {
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    uploadBtn.after('<span class="uppish-progress ml-1"></span>');

                    myXhr.upload.addEventListener('progress', function (event) {
                        var percent = 0;
                        var position = event.loaded || event.position;
                        var total = event.total;

                        if (event.lengthComputable) {
                            percent = Math.ceil(position / total * 100);
                        }

                        uploadBtn.siblings('.uppish-progress').text(percent + '%');

                        element.val(null);
                    });
                }
                return myXhr;
            },
            success: function (data) {
                return data;
            },
            error: function (error) {
                console.error(error);
            },
            async: true,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            timeout: 60000
        });

        return ajx;
    };

    function handleErrors(element, error) {
        element.after('<span class="uppish-error text-danger ml-1 small"></span>');
        var errorElem = element.siblings('.uppish-error');

        errorElem.text(error);
        element.val(null);

        setTimeout(function(){
            errorElem.addClass('fade-out').delay(1000).queue(function(next){
                errorElem.remove();
                next();
            });
        }, 2000);
    }

    $('body').on('change', '.js-uppish', function(event) {
        var input    = $(this);
        var file     = input[0].files[0];
        var fileAttr = input.data('name');

        // Get individual setup from the input[file] itself to override.
        var maxSize    = input.data('size') ?? uppish.maxUploadSize;
        var accept     = input.attr('accept') ? stringToArray(input.attr('accept')) : uppish.acceptedMimes;
        var maxFiles   = input.attr('data-limit') ? parseInt(input.attr('data-limit')) : uppish.maximumFiles;

        // Limit max files to respect the configured value.
        maxFiles = maxFiles > uppish.maximumFiles ? uppish.maximumFiles : maxFiles;

        if(file) {
            var upload   = new Upload(file);
            var fileName = upload.getName();

            var inputBtn      = input.parent('.btn-uppish');
            var uploadedPanel = inputBtn.siblings(".uppish-uploads");
            var uploaded      = uploadedPanel.find('.js-uppish-uploaded-file').length;
            var isMultiple    = isMultipleFiles(input) ? true : false;

            if (upload.getSize() > maxSize) {
                handleErrors(inputBtn, 'File size exceeds maximum upload size');
                return false;
            }

            if (isMimes(accept)) {
                if ($.inArray(upload.getType(), accept) == -1) {
                    handleErrors(inputBtn, 'File type not supported');
                    return false;
                }
            } else {
                accept = sanitizeExtensions(accept);
                if ($.inArray(upload.getExtension(), accept) == -1) {
                    handleErrors(inputBtn, 'File type not supported');
                    return false;
                }
            }

            if (isMultiple) {
                if (uploaded >= maxFiles) {
                    handleErrors(inputBtn, 'You exceeded the maximum number of files for the field');
                    return false;
                }
            }

            // Execute the upload.
            var result = upload.doUpload(input);

            result.done(function(data) {
                if ('object' === typeof data) {
                    console.error(data);
                } else {
                    inputBtn.siblings('.uppish-progress').remove();
                    inputBtn.after(`<div class="uppish-success badge badge-success badge-pill ml-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            Done
                        </div>`);

                    setTimeout(function(){
                        var successBadge = inputBtn.siblings('.uppish-success');
                        successBadge.addClass('fade-out').delay(1000).queue(function(next){
                            successBadge.remove();
                            next();
                        });
                    }, 2000);

                    if (isMultipleFiles(input)) {
                        // Treat as multiple attachments.
                        uploadedPanel.append(inputElem(fileAttr, fileName, data));
                    } else {
                        // Treat as single attachment: Replace any previous upload.
                        uploadedPanel.html(inputElem(fileAttr, fileName, data));
                    }
                    manageMandatoryField(input);

                    console.info(`File '${fileName}' uploaded successfully!`);
                }
            });
        }
    });

    $('body').on('click', '.js-uppish-delete-file', function() {
        if (confirm('Are you sure, you want to delete this file?')) {
            var thisBtn = $(this);
            var fileRow = thisBtn.parent('.js-uppish-uploaded-file');
            var input   = fileRow.parent('.uppish-uploads').siblings('.btn-uppish').find('.js-uppish');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: uppish.routeDelete,
                dataType: "json",
                data: { file: thisBtn.attr('data-file') },
                success: function (data) {
                    fileRow.slideUp("slow", function() {
                        fileRow.remove();
                        manageMandatoryField(input);
                        console.log('File deleted successfully!');
                    });
                },
                error: function (data) {
                    console.error(error);
                }
            });
        }
    });

    /**
    * Manage form Item Validation.
    */
    $('form').on('change submit', function(e) {
        $('.js-uppish').each(function (index) {
            var input = $(this);
            var inputBtn = input.parent('.btn-uppish');
            if (input.is(':invalid')) {
                inputBtn.addClass('border-danger').removeClass('border-success');
                inputBtn.siblings('.badge.badge-danger').remove(); // remove previously appended badges.
                inputBtn.after('<span class="badge badge-danger ml-2">Required</span>');
            } else {
                inputBtn.removeClass('border-danger').addClass('border-success');
                inputBtn.siblings('.badge.badge-danger').remove();
            }
        });
    });
});
