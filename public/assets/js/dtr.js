$(function() {
    var bioID, officeID, divisionID, dateFrom, dateTo;
    var dateRange = initDateRangeInput('#dtr-drange');

    $.fn.setOffice = function(id, text) {
        officeID = id;

        $('#btn-office').text(text)
                        .attr('disabled', 'disabled');
        $('#btn-grp-division').show(500);

        generateDivisions(id);
        //alert([officeID, divisionID]);
    }

    $.fn.setDivision = function(id, text) {
        divisionID = id;
        $('#btn-division').text(text)
                          .attr('disabled', 'disabled');
        $('#btn-reset').fadeIn(500);

        toggleTableData('show');
    }

    $.fn.resetSeleted = function() {
        $('#btn-grp-division').fadeOut(500, function() {
            $('#btn-division').text('Select Division ')
                              .removeAttr('disabled');
            $('#btn-office').text('Select Office ')
                            .removeAttr('disabled');
            clearAllData();
            toggleTableData('hide');
        });

        $('#btn-reset').fadeOut(500);
    }

    $.fn.openPrintDetails = function(_bioID) {
        bioID = _bioID;

        $('#modal-dtr-print').modal('show')
                             .modal('handleUpdate')
                             .on('shown.bs.modal', function () {
            $('#biometics-id').val(_bioID);
            //$('#dtr-drange').trigger('focus');

            dateRange.on('apply.daterangepicker', function(ev, picker) {
                var monthText = picker.startDate.format('MMMM'),
                    startDate = picker.startDate.format('D'),
                    endDate = picker.endDate.format('D'),
                    year = picker.startDate.format('YYYY');
                var dateRangeText = "[" + monthText + " " + startDate + "-" +
                                    endDate + ", " + year + "]";
                $(this).val(picker.startDate.format('"YYYY-MM-DD"') + ' to ' +
                            picker.endDate.format('"YYYY-MM-DD"'));
                $('#drange-textual').text(dateRangeText);

                dateFrom = picker.startDate.format('YYYY-MM-DD');
                dateTo = picker.endDate.format('YYYY-MM-DD');
            });

            dateRange.on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                $('#drange-textual').text('');
                dateFrom = "";
                dateTo = "";
            });
        }).on('hidden.bs.modal', function (e) {
            clearAllData();
        });
    }

    $.fn.printDTR = function() {
        if (dateFrom && dateTo) {
            $('#inp-key').val(bioID);
            $('#inp-datefrom').val(dateFrom);
            $('#inp-dateto').val(dateTo);
            $('#inp-papertype').val(1);
            $('#inp-toggle').val('preview');
            //window.open(url, '_blank');
            $('#frm-dtr-print').submit();
        } else {
            alert('Select first a date range.');
            $('#dtr-drange').trigger('focus');
        }
    }

    function clearAllData() {
        bioID = "";
        dateFrom = "";
        dateTo = "";

        $('#biometics-id').val('');
        $('#dtr-drange').val('');
        $('#drange-textual').text('');

        $('#inp-key').val('');
        $('#inp-datefrom').val('');
        $('#inp-dateto').val('');
        $('#inp-papertype').val('');
        $('#inp-toggle').val('');
    }

    function initDateRangeInput(element) {
        var dateRange = $(element).daterangepicker({
            autoUpdateInput: false,
            singleDatePicker: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        return dateRange
    }

    function toggleTableData(toggle) {
        if (toggle == 'show') {
            var url = "dtr/show-employee?officeid=" + officeID +
                      "&divisionid=" + divisionID;
            $('#data-body').load(url, function() {
                $(this).fadeIn(500);
            });
        } else {
            $('#data-body').fadeOut(500, function() {
                $(this).html('');
            });
        }
    }

    function generateDivisions(id) {
        $('#dropdown-division').html('');
        $.get('dtr/show-division/' + id, function(data) {
            var jsonData = JSON.parse(data);
            var divButton = '<h6 class="dropdown-header">Divisions</h6>';

            $.each(jsonData, function(i, dat) {
                divButton += '<a class="dropdown-item" ' +
                             'onclick="$(this).setDivision(' +
                             "'" + dat['id'] + "','" + dat['division_name'] + "'" +
                             ');">' + dat['division_name'] + '</a>';
            });
            $('#dropdown-division').append(divButton);
        }).fail(function() {
            fetchAjaxDivision(id);
        });
    }
});
