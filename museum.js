//Plugin Name: Museum
//file: museum.js
console.log('museum.js wordt geladen...');

jQuery(document).ready(function ($) {
    var frame;

    function updateImageGallery() {
        var ids = $('#museum_review_images').val().split(',');
        var $gallery = $('#museum_review_images_gallery').empty();

        if (!ids || ids.length === 0 || ids[0] === "") return;

        ids.forEach(function (id) {
            var $image = $('<img>').attr('src', 'https://via.placeholder.com/100?text=' + id);
            // Deze placeholder-URL moet worden vervangen door een werkelijke afbeelding-URL.
            // Je kunt een AJAX-verzoek gebruiken om de werkelijke URL van de afbeelding op te halen op basis van de ID.
            $gallery.append($image);
        });
    }

    $('#upload_images_button').on('click', function (e) {
        e.preventDefault();

        if (frame) {
            frame.open();
            return;
        }

        frame = wp.media({
            title: mr_upload.title,
            button: {
                text: mr_upload.button
            },
            multiple: true
        });

        frame.on('select', function () {
            // Haal de selectie op en maak een array van de ID's
            var selection = frame.state().get('selection');
            var ids = selection.map(function (attachment) {
                return attachment.id;
            }).join(',');

            // Sla de lijst van ID's op in het verborgen veld
            $('#museum_review_images').val(ids);
            updateImageGallery();

            // Optioneel: Direct weergeven van de geselecteerde afbeeldingen als preview
            var imagesHtml = '';
            selection.each(function (attachment) {
                imagesHtml += '<img src="' + attachment.attributes.url + '" style="max-width: 90px; margin-right: 5px;" />';
            });
            $('#image_preview').html(imagesHtml);
        });
        frame.open();
    });

    updateImageGallery(); // Update de galerij bij het laden van de pagina
});

