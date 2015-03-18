var templateLoader = (function($, host) {
    return {
        loadExtTemplate: function(path) {

            var tmplLoader = $.get(path)
                .success(function(result){
                    $("head").append(result);
                    startImageGallery();
                });

        }
    };
})(jQuery, document);