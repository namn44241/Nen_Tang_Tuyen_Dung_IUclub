jQuery(document).ready(function ($) {
  $(document).on("focus", ".user-contact-social-profile", function () {
    var $iconlist = $(".rtc-icons-wrap").clone();
    $(this).after($iconlist.html());
    $(this).siblings(".rtc-icons-list").fadeIn("slow");
    var input = '<span id="remove-icon-list" class="fas fa-times"></span>';
    $(this).siblings(".rtc-icons-list:visible").prepend(input);
  });

  $(document).on("blur", ".user-contact-social-profile", function (e) {
    e.preventDefault();
    $(this)
      .siblings(".rtc-icons-list")
      .fadeOut("slow", function () {
        $(this).remove();
      });
  });

  $(document).on("keyup", ".user-contact-social-profile", function () {
    var value = $(this).val();
    var matcher = new RegExp(value, "gi");
    $(this)
      .siblings(".rtc-icons-list")
      .children("li")
      .show()
      .not(function () {
        return matcher.test($(this).find("svg").attr("data-icon"));
      })
      .hide();
  });

  $("body").on("click", ".rtc-contact-social-add:visible", function (e) {
    e.preventDefault();
    da = $(this).siblings(".rtc-contact-sortable-links").attr("id");
    if ($("body").hasClass("elementor-editor-active")) {
      suffix = "REPLACE_TO_ID";
    } else {
      suffix = da.match(/\d+/);
    }
    var maximum = 0;
    $(".rtc-contact-social-icon-wrap:visible").each(function () {
      var value = $(this).attr("data-id");
      if (!isNaN(value)) {
        value = parseInt(value);
        maximum = value > maximum ? value : maximum;
      }
    });
    var newinput = $(".rtc-contact-social-template").clone();
    maximum++;
    newinput
      .find(".rtc-contact-social-length")
      .attr(
        "name",
        "widget-rtc_contact_social_links[" +
        suffix +
        "][social][" +
        maximum +
        "]"
      );
    newinput
      .find(".user-contact-social-profile")
      .attr(
        "name",
        "widget-rtc_contact_social_links[" +
        suffix +
        "][social_profile][" +
        maximum +
        "]"
      );
    newinput.html(function (i, oldHTML) {
      return oldHTML.replace(/{{ind}}/g, maximum);
    });
    $(this)
      .siblings(".rtc-contact-sortable-links")
      .find(".rtc-contact-social-icon-holder")
      .before(newinput.html())
      .trigger("change");
  });

  $("body").on("click", ".rtc-social-add", function (e) {
    e.preventDefault();
    da = $(this).siblings(".rtc-sortable-links").attr("id");
    if ($("body").hasClass("elementor-editor-active")) {
      suffix = "REPLACE_TO_ID";
    } else {
      suffix = da.match(/\d+/);
    }
    var maximum = 0;
    $(".rtc-social-icon-wrap:visible").each(function () {
      var value = $(this).attr("data-id");
      if (!isNaN(value)) {
        value = parseInt(value);
        maximum = value > maximum ? value : maximum;
      }
    });
    var newinput = $(".rtc-social-template").clone();
    maximum++;
    newinput
      .find(".rtc-social-length")
      .attr(
        "name",
        "widget-rtc_social_links[" + suffix + "][social][" + maximum + "]"
      );
    newinput
      .find(".user-social-profile")
      .attr(
        "name",
        "widget-rtc_social_links[" +
        suffix +
        "][social_profile][" +
        maximum +
        "]"
      );
    newinput.html(function (i, oldHTML) {
      return oldHTML.replace(/{{indexes}}/g, maximum);
    });

    $(this)
      .siblings(".rtc-sortable-links")
      .find(".rtc-social-icon-holder")
      .before(newinput.html());
  });

  $("body").on("click", "#remove-icon-list", function (e) {
    e.preventDefault();
    $(this)
      .parent()
      .fadeOut("slow", function () {
        $(this).remove();
      });
  });

  $("body").on("click", ".del-rtc-icon, .del-contact-rtc-icon", function () {
    var con = confirm(sociconsmsg.msg);
    if (!con) {
      return false;
    }
    $(this)
      .parent()
      .fadeOut("slow", function () {
        $(this).remove();
        $(".rtc-contact-social-add").focus().trigger("change");
        $(".rtc-social-add").focus().trigger("change");
      });
    return;
  });

  $(document).on("focus", ".user-social-profile", function () {
    var $iconlist = $(".rtc-icons-wrap").clone();
    $(this).after($iconlist.html());
    $(this).siblings(".rtc-icons-list").fadeIn("slow");
    var input = '<span id="remove-icon-list" class="fas fa-times"></span>';
    $(this).siblings(".rtc-icons-list:visible").prepend(input);
  });

  $(document).on("blur", ".user-social-profile", function (e) {
    e.preventDefault();

    $(this)
      .siblings(".rtc-icons-list")
      .fadeOut("slow", function () {
        $(this).remove();
      });
  });

  $(document).on("click", ".rtc-icons-list li", function (event) {
    var prefix = $(this).children("svg").attr("data-prefix");
    var icon = $(this).children("svg").attr("data-icon");
    var val = prefix + " fa-" + icon;
    $(this)
      .parent()
      .siblings(".rtc-social-length")
      .attr("value", "https://" + icon + ".com");
    $(this)
      .parent()
      .parent()
      .siblings(".rtc-contact-social-length")
      .attr("value", "https://" + icon + ".com");
    $(this).parent().siblings(".user-contact-social-profile").val(icon);
    $(this).siblings(".rtc-icons-wrap-search").remove("slow");
    $(this)
      .parent()
      .fadeOut("slow", function () {
        $(this).remove();
      });
    event.preventDefault();
  });

  $(document).on("click", ".rtc-icons-list li", function (event) {
    var prefix = $(this).children("svg").attr("data-prefix");
    var icon = $(this).children("svg").attr("data-icon");
    var val = prefix + " fa-" + icon;

    $(this).parent().siblings(".user-social-profile").val(icon);
    $(this)
      .parent()
      .siblings(".rtc-contact-social-length")
      .attr("value", "https://" + icon + ".com");

    $(this)
      .parent()
      .siblings(".user-social-links")
      .attr("value", "https://" + icon + ".com");
    $(this).parent().siblings(".user-social-links").trigger("change");
    $(this).parent().siblings(".user-social-profile").trigger("change");
    event.preventDefault();
  });
  $(document).on("keyup", ".user-social-profile", function () {
    var value = $(this).val();
    var matcher = new RegExp(value, "gi");
    $(this)
      .siblings(".rtc-icons-list")
      .children("li")
      .show()
      .not(function () {
        return matcher.test($(this).find("svg").attr("data-icon"));
      })
      .hide();
  });

  $(document).on("keyup", ".rrtc-search-icon", function () {
    var value = $(this).val();
    var matcher = new RegExp(value, "gi");
    $(this)
      .siblings(".rara-font-awesome-list")
      .find("li")
      .show()
      .not(function () {
        return matcher.test($(this).find("svg").attr("data-icon"));
      })
      .hide();
  });
  // Set all variables to be used in scope
  var frame;

  // ADD IMAGE LINK
  $("body").on("click", ".rara-upload-button", function (e) {
    e.preventDefault();
    var clicked = $(this).closest("div");
    var custom_uploader = wp
      .media({
        title: "RARA Image Uploader",
        // button: {
        //     text: 'Custom Button Text',
        // },
        multiple: false, // Set this to true to allow multiple files to be selected
      })
      .on("select", function () {
        var attachment = custom_uploader
          .state()
          .get("selection")
          .first()
          .toJSON();
        var str = attachment.url.split(".").pop();
        var strarray = ["jpg", "gif", "png", "jpeg"];
        if ($.inArray(str, strarray) != -1) {
          clicked
            .find(".rara-screenshot")
            .empty()
            .hide()
            .append(
              '<img src="' +
              attachment.url +
              '"><a class="rara-remove-image"></a>'
            )
            .slideDown("fast");
        } else {
          clicked
            .find(".rara-screenshot")
            .empty()
            .hide()
            .append("<small>" + raratheme_companion_uploader.msg + "</small>")
            .slideDown("fast");
        }

        clicked.find(".rara-upload").val(attachment.id).trigger("change");
        clicked
          .find(".rara-upload-button")
          .val(raratheme_companion_uploader.change);
      })
      .open();
  });

  $("body").on("click", ".rara-remove-image", function (e) {
    var selector = $(this).parent("div").parent("div");
    selector.find(".rara-upload").val("").trigger("change");
    selector.find(".rara-remove-image").hide();
    selector.find(".rara-screenshot").slideUp();
    selector
      .find(".rara-upload-button")
      .val(raratheme_companion_uploader.upload);

    return false;
  });

  // set var
  var in_customizer = false;

  // check for wp.customize return boolean
  if (typeof wp !== "undefined") {
    in_customizer = typeof wp.customize !== "undefined" ? true : false;
  }
  $(document).on("click", ".rara-font-group li", function () {
    var id = $(this).parents(".widget").attr("id");
    $("#" + id)
      .find(".rara-font-group li")
      .removeClass();
    $("#" + id)
      .find(".icon-receiver")
      .siblings("a")
      .remove(".rara-remove-icon");
    $(this).addClass("selected");
    var prefix = $(this)
      .parents(".rara-font-awesome-list")
      .find(".rara-font-group li.selected")
      .children("svg")
      .attr("data-prefix");
    var icon = $(this)
      .parents(".rara-font-awesome-list")
      .find(".rara-font-group li.selected")
      .children("svg")
      .attr("data-icon");
    var aa = prefix + " fa-" + icon;
    $(this)
      .parents(".rara-font-awesome-list")
      .siblings("p")
      .find(".hidden-icon-input")
      .val(aa);
    $(this)
      .parents(".rara-font-awesome-list")
      .siblings("p")
      .find(".icon-receiver")
      .html('<i class="' + aa + '"></i>');
    $("#" + id)
      .find(".icon-receiver")
      .append('<a class="rara-remove-icon"></a>');

    if (in_customizer) {
      $(".hidden-icon-input").trigger("change");
    }

    $(this).focus().trigger("change");
  });

  // $(document).on('click', '.link-image-repeat .cross', function() {

  // });

  function rara_initColorPicker(widget) {
    widget.find(".rara-widget-color-field").wpColorPicker({
      change: _.throttle(function () {
        // For Customizer
        jQuery(this).trigger("change");
      }, 3000),
    });
  }
  function onFormUpdate(event, widget) {
    rara_initColorPicker(widget);
  }

  jQuery(document).on("widget-added widget-updated", onFormUpdate);

  jQuery(document).ready(function () {
    jQuery(".widget:has(.rara-widget-color-field)").each(function () {
      rara_initColorPicker(jQuery(this));
    });
  });

  /** Remove icon function */
  $(document).on("click", ".rara-remove-icon", function () {
    var id = $(this).parents(".widget").attr("id");
    $("#" + id)
      .find(".rara-font-group li")
      .removeClass();
    $("#" + id)
      .find(".hidden-icon-input")
      .val("");
    $("#" + id)
      .find(".icon-receiver")
      .html('<i class=""></i>')
      .children("a")
      .remove(".rara-remove-icon");
    if (in_customizer) {
      $(".hidden-icon-input").trigger("change");
    }
    return $("#" + id)
      .find(".icon-receiver")
      .trigger("change");
  });

  /** To add remove button if icon is selected in widget update event */
  $(document).on("widget-updated", function (e, widget) {
    // "widget" represents jQuery object of the affected widget's DOM element
    var $this = $("#" + widget[0].id).find(".yes");
    $this.append('<a class="rara-remove-icon"></a>');
  });

  raratheme_pro_check_icon();

  /** function to check if icon is selected and saved when loading in widget.php */
  function raratheme_pro_check_icon() {
    $(".icon-receiver").each(function () {
      // alert($(this).children('.svg-inline--fa').attr('class'));
      if ($(this).hasClass("yes")) {
        $(this).append('<a class="rara-remove-icon"></a>');
      }
    });
  }

  $("body").on("click", ".raratheme-social-add", function (e) {
    e.preventDefault();
    // da = document.getElementsByClassName('raratheme-sortable-icons')[1].getAttribute("id");
    da = $(this).siblings(".raratheme-sortable-icons").attr("id");
    suffix = da.match(/\d+/);
    var len = $(".companion-social-length:visible").length;
    len++;
    var newinput = $(".raratheme-social-template").clone();
    newinput.html(function (i, oldHTML) {
      newinput
        .find(".companion-social-length")
        .attr(
          "name",
          "widget-raratheme_social_links[" + suffix + "][social][" + len + "]"
        );
    });

    $(this)
      .siblings(".raratheme-sortable-icons")
      .find(".raratheme-social-icon-holder")
      .before(newinput.html());
    $("ul.rtc-sortable-icons input").trigger("change");
  });

  //  $(document.body).on('blur', '.companion-social-length', function() {
  //     var $this = $(this),
  //         $_socicon = false,
  //         url;

  //     if ( url = $this.val().toLowerCase() ) {
  //         $.each(social_icons_admin_widgets.supported_url_icon, function(index, icon) {
  //             if (url.indexOf(index) !== -1) {
  //                 $_socicon = icon;
  //                 return true;
  //             }
  //         });

  //         if (!$_socicon) {
  //             $.each(social_icons_admin_widgets.allowed_socicons, function(index, icon) {
  //                 if (url.indexOf(icon) !== -1) {
  //                     $_socicon = icon;
  //                     return true;
  //                 }
  //             });
  //         }
  //     }
  //     if ($_socicon != false) {

  //         $this.prev().attr('class', 'raratheme-social-icons-field-handle fas fa-' + $_socicon).css('font-family', 'FontAwesome');
  //     } else {

  //         $this.prev().attr('class', 'raratheme-social-icons-field-handle fas fa-plus').css('font-family', 'FontAwesome');
  //     }

  // });
  $("body").on("click", ".del-icon", function () {
    var con = confirm(confirming.are_you_sure);
    if (!con) {
      return false;
    }
    $(this)
      .parent()
      .parent()
      .fadeOut("slow", function () {
        $(this).remove();
        $(".raratheme-social-add").focus().trigger("change");
      });

    return;
  });

  $("body").on("click", "#add-logo:visible", function (e) {
    e.preventDefault();
    da = $(this).siblings(".widget-client-logo-repeater").attr("id");
    if ($("body").hasClass("elementor-editor-active")) {
      suffix = "REPLACE_TO_ID";
    } else {
      suffix = da.match(/\d+/);
    }
    len = 0;
    $(this)
      .siblings(".widget-client-logo-repeater")
      .children(".link-image-repeat:visible")
      .each(function () {
        var value = $(this).attr("data-id");
        if (!isNaN(value)) {
          value = parseInt(value);
          len = value > len ? value : len;
        }
      });

    len++;
    var newinput = $(".rrtc-client-logo-template").clone();
    newinput.html(function (i, oldHTML) {
      newinput.find(".link-image-repeat").attr("data-id", len);
      newinput
        .find(".featured-link")
        .attr(
          "name",
          "widget-raratheme_client_logo_widget[" +
          suffix +
          "][link][" +
          len +
          "]"
        );
      newinput
        .find(".widget-upload .link")
        .attr(
          "name",
          "widget-raratheme_client_logo_widget[" +
          suffix +
          "][image][" +
          len +
          "]"
        );
    });
    $(this)
      .siblings(".widget-client-logo-repeater")
      .find(".cl-repeater-holder")
      .before(newinput.html());
    return $(this).focus().trigger("change");
  });

  $("body").on("click", "#add-faq:visible", function (e) {
    e.preventDefault();
    da = $(this).siblings(".widget-client-faq-repeater").attr("id");
    if ($("body").hasClass("elementor-editor-active")) {
      suffix = "REPLACE_TO_ID";
    } else {
      suffix = da.match(/\d+/);
    }
    len = 0;
    $(".faqs-repeat:visible").each(function () {
      var value = $(this).attr("data-id");
      if (!isNaN(value)) {
        value = parseInt(value);
        len = value > len ? value : len;
      }
    });
    len++;
    var newinput = $(".rrtc-faq-template").clone();
    newinput.html(function (i, oldHTML) {
      newinput.find(".faqs-repeat").attr("data-id", len);
      newinput
        .find(".question")
        .attr(
          "name",
          "widget-raratheme_companion_faqs_widget[" +
          suffix +
          "][question][" +
          len +
          "]"
        );
      newinput
        .find(".answer")
        .attr(
          "name",
          "widget-raratheme_companion_faqs_widget[" +
          suffix +
          "][answer][" +
          len +
          "]"
        );
    });
    // $('.cl-faq-holder').before(newinput.html());
    $(this)
      .siblings(".widget-client-faq-repeater")
      .find(".cl-faq-holder")
      .before(newinput.html());
    return $(this).focus().trigger("change");
  });
  $("body").on("click", ".cross", function (e) {
    $(this)
      .parent()
      .fadeOut("slow", function () {
        $(this).remove();
        if (in_customizer) {
          $("#add-logo").focus().trigger("change");
        }
      });
    return $(this).focus().trigger("change");
  });

  $(document).on("keyup", ".wptec-search-icon", function () {
    var value = $(this).val();
    var matcher = new RegExp(value, "gi");
    $(this)
      .siblings(".rara-font-awesome-list")
      .find("li")
      .show()
      .not(function () {
        return matcher.test($(this).find("svg").attr("data-icon"));
      })
      .hide();
  });

  $("body").on("click", "#add-user-socicon", function (e) {
    e.preventDefault();
    da = $(this).siblings(".raratheme-sortable-icons").attr("id");
    if ($("body").hasClass("elementor-editor-active")) {
      suffix = "REPLACE_TO_ID";
    } else {
      suffix = da.match(/\d+/);
    }
    var maximum = 0;
    $(".social-share-list").each(function () {
      var value = $(this).attr("data-id");
      if (!isNaN(value)) {
        value = parseInt(value);
        maximum = value > maximum ? value : maximum;
      }
    });
    var newField = $(".raratheme-socicon-template").clone();
    maximum++;
    var name =
      "widget-raratheme_author_bio[" + suffix + "][socicon][" + maximum + "]";
    newField.find(".user-social-links").attr("name", name);

    var profile =
      "widget-raratheme_author_bio[" +
      suffix +
      "][socicon_profile][" +
      maximum +
      "]";
    newField.find(".user-social-profile").attr("name", profile);

    newField.html(function (i, oldHTML) {
      return oldHTML.replace(/{{socicon_index}}/g, maximum);
    });
    $(".raratheme-socicon-holder").before(newField.html());
  });

  $("body").on("click", ".del-user-social-links", function (e) {
    var confirmation = confirm(sociconsmsg.msg);
    if (!confirmation) {
      return false;
    }
    $(this)
      .parent()
      .fadeOut("slow", function () {
        $(this).remove();
        $("#add-user-socicon").focus().trigger("change");
      });
    return;
  });

  // Upload / Change Image
  function raratheme_image_upload(button_class) {
    var _custom_media = true,
      _orig_send_attachment = wp.media.editor.send.attachment;

    jQuery("body").on("click", button_class, function (e) {
      var button_id = "#" + jQuery(this).attr("id"),
        self = jQuery(button_id),
        send_attachment_bkp = wp.media.editor.send.attachment,
        button = jQuery(button_id),
        id = button.attr("id").replace("-button", "");

      _custom_media = true;

      wp.media.editor.send.attachment = function (props, attachment) {
        if (_custom_media) {
          jQuery("#" + id + "-preview")
            .attr("src", attachment.url)
            .css("display", "block");
          jQuery("#" + id + "-remove").css("display", "inline-block");
          jQuery("#" + id + "-noimg").css("display", "none");
          jQuery("#" + id)
            .val(attachment.url)
            .trigger("change");
        } else {
          return _orig_send_attachment.apply(button_id, [props, attachment]);
        }
      };

      wp.media.editor.open(button);

      return false;
    });
  }
  raratheme_image_upload(".raratheme-media-upload");

  $("body").on("click", ".raratheme-itw-add", function (e) {
    e.preventDefault();
    da = $(this).siblings(".raratheme-img-text-outer").attr("id");
    if ($("body").hasClass("elementor-editor-active")) {
      suffix = "REPLACE_TO_ID";
    } else {
      suffix = da.match(/\d+/);
    }
    var maximum = 0;
    $(".image-text-widget-wrap:visible").each(function () {
      var value = $(this).attr("data-id");
      if (!isNaN(value)) {
        value = parseInt(value);
        maximum = value > maximum ? value : maximum;
      }
    });
    var newinput = $(".raratheme-itw-template").clone();

    newinput.html(function (i, oldHTML) {
      maximum++;

      newinput.find(".image-text-widget-wrap").attr("data-id", maximum);
      newinput
        .find(".text input")
        .attr(
          "name",
          "widget-raratheme_image_text_widget[" + suffix + "][link_text][]"
        );
      newinput
        .find(".link input")
        .attr(
          "name",
          "widget-raratheme_image_text_widget[" + suffix + "][link][]"
        );
      newinput
        .find(".widget-upload input")
        .attr(
          "name",
          "widget-raratheme_image_text_widget[" + suffix + "][image][]"
        );

      newinput
        .find(".text input")
        .attr(
          "id",
          "widget-raratheme_image_text_widget[" + suffix + "][link_text][]"
        );
      newinput
        .find(".link input")
        .attr(
          "id",
          "widget-raratheme_image_text_widget[" + suffix + "][link][]"
        );
      newinput
        .find(".widget-upload input")
        .attr(
          "id",
          "widget-raratheme_image_text_widget[" + suffix + "][image][]"
        );

      newinput
        .find(".text label")
        .attr(
          "for",
          "widget-raratheme_image_text_widget[" + suffix + "][link_text][]"
        );
      newinput
        .find(".link label")
        .attr(
          "for",
          "widget-raratheme_image_text_widget[" + suffix + "][link][]"
        );
      newinput
        .find(".widget-upload label")
        .attr(
          "for",
          "widget-raratheme_image_text_widget[" + suffix + "][image][]"
        );

      // newinput.find( '.raratheme-screenshot' ).attr('id','widget-raratheme_image_text_widget-'+suffix+'-image');

      // oldHTML.replace(/{{indexes}}/g, maximum);
    });

    $(this)
      .siblings(".raratheme-img-text-outer")
      .find(".itw-holder")
      .before(newinput.html());
    // $(this).siblings('.raratheme-sortable-links').find('.raratheme-social-icon-holder').before(newinput.html());
  });

  $("body").on("click", ".image-text-cancel", function (e) {
    e.preventDefault();
    $(this)
      .parent()
      .fadeOut("slow", function () {
        $(this).remove();
      });
  });

  $(document).on("click", ".rtc_tax_media_button", function (e) {
    e.preventDefault();
    var file_frame;
    var allowed_filetype = ["image/jpeg", "image/png"];
    if (file_frame) file_frame.close();

    file_frame = wp.media.frames.file_frame = wp.media({
      title: "Choose Taxonomy Image",
      button: {
        text: "Insert Image",
      },
      library: {
        type: allowed_filetype,
      },
      multiple: false,
    });

    file_frame.on("select", function () {
      var selection = file_frame.state().get("selection");
      selection.map(function (attachment, i) {
        var attachment = attachment.toJSON();
        $("#category-image-wrapper").html(
          '<img src="' + attachment.sizes.thumbnail.url + '"/>'
        );
        $("#category-image-id").val(attachment.id);
      });
    });

    file_frame.open();
  });

  $(document).on("click", ".rtc_tax_media_remove", function (e) {
    e.preventDefault();
    $("#category-image-wrapper").html("");
    $("#category-image-id").val("");
  });

  $(document).on("change", ".cta-button-number", function (e) {
    if ($(this).val() == 2) {
      $(this).parent().siblings(".button-one-info, .button-two-info").show();
    }
    else {
      $(this).parent().siblings(".button-two-info").fadeOut();
    }
  });
});
