!function(t){t(".scriptura-media-uploader").click(function(e){var i=t(this).parent();e.preventDefault();var r=wp.media({title:"Choisir une image de fond",multiple:!1}).on("select",function(){var e=r.state().get("selection"),a=e.first().toJSON();t("input",i).val(a.url),t("img",i).attr("src",a.url)}).open()})}(jQuery),function(t){t(".scriptura-media-remove").click(function(e){t("#scriptura_def_thumbnail").val(""),t("#visual_scriptura_def_thumbnail").attr("src",$templateUri+"/Images/Null.svg"),e.preventDefault()})}(jQuery);