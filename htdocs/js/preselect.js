jQuery.fn.selectOptionWithText = function selectOptionWithText(targetText) {
    return this.each(function () {
        var $selectElement, $options, $targetOption;

        $selectElement = jQuery(this);
        $options = $selectElement.find('option');
        $targetOption = $options.filter(
            function () {return jQuery(this).text() == targetText}
        );

        // We use `.prop` if it's available (which it should be for any jQuery
        // versions above and including 1.6), and fall back on `.attr` (which
        // was used for changing DOM properties in pre-1.6) otherwise.
        if ($targetOption.prop) {
            $targetOption.prop('selected', true);
        } 
        else {
            $targetOption.attr('selected', 'true');
        }
    });
}


document.addEventListener("DOMContentLoaded", function(event) {
    window.onload = function(){

        var dropdown = $("select[name='UpdateForm[accountType]']"),
            optionToSelect = dropdown.attr('id');

        var dropdownDefaultAddresses = $("select[name='DefaultAddressesForm[setDefaultBehavior]']"),
            defaultAddressesOption = dropdownDefaultAddresses.attr('id');

        var dropdownArchiveAfter = $("select[name='EmailArchivingForm[archiveMessageAfter]']"),
            archiveAfterOption = dropdownArchiveAfter.attr('id');

        var dropdownDeleteAfter = $("select[name='EmailArchivingForm[deleteMessageAfter]']"),
            deleteAfterOption = dropdownDeleteAfter.attr('id');

        jQuery(dropdown).selectOptionWithText(optionToSelect);
        jQuery(dropdownDefaultAddresses).selectOptionWithText(defaultAddressesOption);
        
        jQuery(dropdownArchiveAfter).selectOptionWithText(archiveAfterOption);
        jQuery(dropdownDeleteAfter).selectOptionWithText(deleteAfterOption);

}
});
