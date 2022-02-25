define([
    "jquery"
], function($) {
    return function (config, element) {
        $(element).on('keyup', function() {
            if (element.value !== '') {
                $(element.nextElementSibling).find('tr').each(function() {
                    let tableRow = $(this);
                    let hide = true;
                    tableRow.find('td').each(function() {
                        let tableCell = $(this);
                        if (tableCell.text().toLowerCase().indexOf(element.value.toLowerCase()) !== -1) {
                            hide = false;
                            return false;
                        }
                    });
                    if(hide) {
                        tableRow.hide();
                    } else {
                        tableRow.show();
                    }
                });
            } else {
                $(element.nextElementSibling).find('tr').show();
            }
        });
    }
});
