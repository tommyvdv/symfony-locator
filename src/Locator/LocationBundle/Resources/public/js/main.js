// wrapper for extra Chosen functionality
chosen = {
    addElement: function(element, value, label) {
        element.append($('<option></option>').val(value).html(label).attr('selected','selected'));
        element.trigger("chosen:updated");
    }
}

// wrapper for adding flash messages
flash = {
    addSuccess: function(message) {
        flash.addMessage(message, 'success');
    },
    addError: function(message) {
        flash.addMessage(message, 'error');
    },
    addWarning: function(message) {
        flash.addMessage(message, 'warning');
    },
    addMessage: function (message, type) {
        $('.flashBag').append(
            $('<div/>',{
                'role': 'alert',
                'class': 'alert alert-'+type,
                'html': message
            })
        );
    }
}

// extra functionality for form
form = {
    /**
     * Add errors to the fields of a form
     *
     * @param element   the form
     * @param errors    array with id/error elements
     */
    addErrors: function(element, errors) {
        form.clearErrors(element);

        errors = errors ? errors : [];

        for(var i = 0; i < errors.length; i++) {
            if(errors[i][0] === null)
            {
                flash.addError(errors[i][1]);
            }
            else
            {
                $('#' + errors[i][0])
                .addClass('formError')
                .after('<div class="errorContainer">' + errors[i][1] + '</div>');
            }
        }
    },
    /**
     * Remove the errors in a form that were added with the addErors method
     *
     * @param element
     */
    clearErrors: function(element)
    {
        $('.flashBag').find('.error,.success,.message').remove();
        element.find('*').removeClass('formError');
        element.find('.errorContainer').remove();
    },
    /**
     * Clear the fields of a form and remove all errors.
     *
     * @param element
     */
    reset: function(element)
    {
        form.clearErrors(element);
        element[0].reset();
    },
    /**
     * submitWithAjax expects two arguments
     *      - the form to be submitted (needs the have an action-attribute)
     *         - this
     *         - $('#jsAddEmployeeForm')[0]
     *      - a function that has to be executed if a response is received
     *          - This function has one argument, response.
     *            The response object has four possible properties
     *                  - error         (false / string)
     *                  - success       (false / string)
     *                  - fieldErrors   (Array with errors per field-id)
     *                  - data          (Array with custom data)
     *
     * @param element
     * @param successFunction
     */
    submitWithAjax: function(element, successFunction) {
        $.ajax( {
            url: $(element).attr('action'),
            type: 'POST',
            data: new FormData(element),
            processData: false,
            contentType: false,
            success: successFunction,
            error: function(response)
            {
                flash.addError('something went wrong');
            }
        } );
    }
}
/*
// main functionality
main = {
    init: function()
    {
        main.chosen();
        main.dataTable();
        main.datePicker();
        main.markdown();
    },
    chosen: function()
    {
        //set defaults for chosen selects and init them
        $('.jsChosen').chosen({
            disable_search_threshold: 10,
            no_results_text: translations.chosen.noResults,
            placeholder_text_multiple: translations.chosen.placeholderTextMultiple,
            placeholder_text_single: translations.chosen.placeholderTextSingle,
            search_contains: true
        });
    },
    dataTable: function()
    {
        // set defaults for all datatables
        $.extend( $.fn.dataTable.defaults, {
            "lengthChange": false,
            "stateSave": true,
            "language": {
                "thousands":      ".",
                "decimal":        ",",
                "emptyTable":     translations.datatable.emptyTable,
                "info":           translations.datatable.info,
                "infoEmpty":      translations.datatable.infoEmpty,
                "infoFiltered":   translations.datatable.infoFiltered,
                "infoPostFix":    translations.datatable.infoPostFix,
                "lengthMenu":     translations.datatable.lengthMenu,
                "loadingRecords": translations.datatable.loading,
                "processing":     translations.datatable.processing,
                "search":         translations.datatable.search,
                "zeroRecords":    translations.datatable.zeroRecords,
                "paginate": {
                    "first":      translations.datatable.first,
                    "last":       translations.datatable.last,
                    "next":       translations.datatable.next,
                    "previous":   translations.datatable.previous
                },
                "aria": {
                    "sortAscending":  translations.datatable.sortAscending,
                    "sortDescending": translations.datatable.sortDescending
                }
            }
        } );
        // init all datatables
        $('.jsDataTable').DataTable();
    },
    datePicker: function()
    {
        $('.jsDatePicker').pickadate();
    },
    markdown: function() {
        $('.jsMarkdown').each(function() {
            var options = {
                container: this,
                theme: {
                    base: settings.markdown.base_template,
                    preview: settings.markdown.preview_template,
                    editor: settings.markdown.editor_template
                }
            };

            var editor = new EpicEditor(options).load();
        });
    }
}
*/
//$(document).ready(main.init);
