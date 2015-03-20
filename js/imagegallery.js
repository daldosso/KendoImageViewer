var startImageGallery = function(){

    var image = kendo.observable({
        url: "http://placekitten.com/300/200"
    });

    var imageList = kendo.observable({
        imageCount: 0,

        imageDataSource: new kendo.data.DataSource({
            schema: {
                model: { id: "id"}
            },
            transport: {
                read: {
                    url: "http://www.adaldosso.com/kendo-image-list/server/kendo-images-crud.php",
                    jsonpCallback: "callback",
                    dataType: "jsonp"
                },
                create: {
                    url: "images.json",
                    dataType: "JSON",
                    type: "POST"
                }
            },

            change: function(){
                var length = this.view().length;
                imageList.set("imageCount", length);
            }
        }),

        scrollingSize: function(){
            var count = this.get("imageCount");
            var width = count * 180;
            return width + "px";
        },

        imageClicked: function(e){
            var index = e.sender.select().index();
            var image = this.imageDataSource.view()[index];

            this.trigger("image:selected", image);
        },

        addImage: function(data){
            var image = this.imageDataSource.add(data);
            this.imageDataSource.sync();
            return image;
        }
    });

    var addImage = kendo.observable({
        name: "",
        url: "",

        saveClicked: function(e) {
            e.preventDefault();

            var validator = $("#image-form").kendoValidator().data("kendoValidator"),
                status = $(".status");
            if (!validator.validate()) {
                status.removeClass("valid").addClass("invalid");
                return false;
            }

            this.trigger("image:save", {
                name: this.get("name"),
                url: this.get("url")
            });

            this.set("name", "");
            this.set("url", "");
        }
    });

    var gallery = kendo.observable({
        addClicked: function(e){
            e.preventDefault();
            this.trigger("image:new");
        }
    });

    gallery.bind("image:new", function(){
        layout.showIn("#main", addImageForm);
    });

    imageList.bind("image:selected", showImage);

    addImage.bind("image:save", function(data){
        var image = imageList.addImage(data);
        showImage(image);
    });

    function showImage(kitteh){
        image.set("url", kitteh.url);
        layout.showIn("#main", kittehView);
    }

    var addImageForm = new kendo.View("add-image-form-template", {
        model: addImage
    });

    var listView = new kendo.View("image-list-template", {
        model: imageList
    });

    var kittehView = new kendo.View("image-view-template", {
        model: image
    });

    var layout = new kendo.Layout("image-gallery-layout-template", {
        model: gallery
    });

    var html = layout.render();
    $("body").html(html);

    layout.showIn("#main", addImageForm);
    layout.showIn("#image-list", listView);

};