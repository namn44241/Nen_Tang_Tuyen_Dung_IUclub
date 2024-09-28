jQuery(document).ready((function(e){var t="job_listing_";function i(t){return!(!window.sessionStorage||"function"!=typeof window.sessionStorage.setItem||e(document.body).hasClass("disable-job-manager-form-state-storage")||t.data("disable-form-state-storage"))}function n(i){var n=e("div.job_listings").index(i),a=i.data("post_id");return void 0!==a&&a||(a=window.location.href.replace(location.hash,"")),t+a+"_"+n}function a(e,t){if(!i(e))return!1;"object"!=typeof t&&(t={});var a=n(e);try{return window.sessionStorage.setItem(a,JSON.stringify(t))}catch(e){}return!1}function o(e){if(!i(e))return!1;var t=n(e);try{var a=window.sessionStorage.getItem(t);if(a)return JSON.parse(a)}catch(e){}return!1}function s(e,t){if(!i(e)||!e)return!1;var n=o(e);return!!n&&(n.persist_results=t,a(e,n))}function r(e){if(!i(e)||!e)return!1;var t=o(e);if(!t)return!1;var n=e.find(".job_filters");return t.form=n.serialize(),a(e,t)}function l(t,i,n){var a=t.find(".job_listings"),o=t.find(".showing_jobs");if("boolean"!=typeof n&&(n=!1),"string"==typeof i.showing&&i.showing||i.showing_links){var s=jQuery("<span>").html(i.showing||"&nbsp;");o.show().html("").html(i.showing_links).prepend(s)}else o.hide();return i.showing_all?o.addClass("wp-job-manager-showing-all"):o.removeClass("wp-job-manager-showing-all"),i.html&&(n?a.append(i.html):a.html(i.html)),!0===t.data("show_pagination")?(t.find(".job-manager-pagination").remove(),i.pagination&&t.append(i.pagination)):(!i.found_jobs||i.max_num_pages<=i.data.page?e(".load_more_jobs:not(.load_previous)",t).hide():e(".load_more_jobs",t).show(),e(".load_more_jobs",t).removeClass("loading").data("page",i.data.page),e("li.job_listing",a).css("visibility","visible")),!0}e(document).on("click","a",(function(){e("div.job_listings").each((function(){r(e(this))}))})),e(document).on("submit","form",(function(){e("div.job_listings").each((function(){r(e(this))}))}));var d=[];function c(){var t=e(this).closest("div.job_listings");t.triggerHandler("update_results",[1,!1]),a(t)}e("div.job_listings").on("click","li.job_listing a",(function(){s(e(this).closest("div.job_listings"),!0)})).on("click",".job-manager-pagination a",(function(){var t=e(this).closest("div.job_listings"),i=e(this).data("page");return t.triggerHandler("update_results",[i,!1]),e("body, html").animate({scrollTop:t.offset().top},600),!1})).on("update_results",(function(t,s,r){var c,g,u,_="",f=e(this),p=f.find(".job_filters"),h=f.find(".job_listings"),m=f.data("per_page"),b=f.data("orderby"),j=f.data("featured_first"),v=f.data("order"),w=f.data("featured"),y=f.data("filled"),k=f.data("remote_position"),x=f.data("job_types"),S=f.data("post_status"),C=e("div.job_listings").index(this);if(!(C<0)){if(function(e){if(!i(e))return!1;var t=n(e);try{window.sessionStorage.removeItem(t)}catch(e){return!1}}(f),d[C]&&d[C].abort(),r&&1!==s||(e("li.job_listing, li.no_job_listings_found",h).css("visibility","hidden"),h.addClass("loading")),f.find(".load_more_jobs").data("page",s),!0===f.data("show_filters")){var H=[];e(':input[name="filter_job_type[]"]:checked, :input[name="filter_job_type[]"][type="hidden"], :input[name="filter_job_type"]',p).each((function(){H.push(e(this).val())})),c=p.find(':input[name^="search_categories"]').map((function(){return e(this).val()})).get(),g="",u="";var I=p.find(':input[name="search_keywords"]'),O=p.find(':input[name="search_location"]'),z=p.find(':input[name="remote_position"]');I.val()!==I.attr("placeholder")&&(g=I.val()),O.val()!==O.attr("placeholder")&&(u=O.val()),z.length&&(k=z.is(":checked")?"true":null),_={lang:job_manager_ajax_filters.lang,search_keywords:g,search_location:u,search_categories:c,filter_job_type:H,filter_post_status:S,per_page:m,orderby:b,featured_first:j,order:v,page:s,featured:w,filled:y,remote_position:k,show_pagination:f.data("show_pagination"),form_data:p.serialize()}}else c=f.data("categories"),g=f.data("keywords"),u=f.data("location"),c&&("string"!=typeof c&&(c=String(c)),c=c.split(",")),_={lang:job_manager_ajax_filters.lang,search_categories:c,search_keywords:g,search_location:u,filter_post_status:S,filter_job_type:x,per_page:m,orderby:b,order:v,page:s,featured:w,filled:y,remote_position:k,show_pagination:f.data("show_pagination")};d[C]=e.ajax({type:"POST",url:job_manager_ajax_filters.ajax_url.toString().replace("%%endpoint%%","get_listings"),data:_,success:function(e){if(e)try{e.data=_,l(f,e,r),h.removeClass("loading"),f.triggerHandler("updated_results",e),function(e,t){if(!i(e))return!1;var n=o(e);n||(n={persist_results:!1});var s=e.find(".job_listings");t.html=s.html(),n.results=t,a(e,n)}(f,e)}catch(e){window.console&&window.console.log(e)}},error:function(e,t,i){window.console&&"abort"!==t&&window.console.log(t+": "+i)},statusCode:{404:function(){window.console&&window.console.log("Error 404: Ajax Endpoint cannot be reached. Go to Settings > Permalinks and save to resolve.")}}})}})),e("#search_keywords, #search_location, #remote_position, .job_types :input, #search_categories, .job-manager-filter").change(c).on("keyup",(function(t){13===t.which&&e(this).trigger("change")})),e(".job_filters").on("click",".reset",(function(){var t=e(this).closest("div.job_listings"),i=e(this).closest("form");return i.find(':input[name="search_keywords"], :input[name="search_location"], .job-manager-filter').not(':input[type="hidden"]').val("").trigger("change.select2"),i.find(':input[name^="search_categories"]').not(':input[type="hidden"]').val("").trigger("change.select2"),i.find(':input[name="filter_job_type[]"]').not(':input[type="hidden"]').prop("checked",!0),i.find(':input[name="remote_position"]').not(':input[type="hidden"]').prop("checked",!1),t.triggerHandler("reset"),t.triggerHandler("update_results",[1,!1]),a(t),!1})).on("submit",(function(){var t=e(this).closest("div.job_listings"),i=e("div.job_listings").index(t);return d[i]&&-1!==[0,4].indexOf(d[i].readyState)&&c.call(this),!1})),e(document.body).on("click",".load_more_jobs",(function(){var t=e(this).closest("div.job_listings"),i=parseInt(e(this).data("page")||1,10);return e(this).addClass("loading"),i+=1,e(this).data("page",i),t.triggerHandler("update_results",[i,!0]),!1})),e.isFunction(e.fn.select2)&&"undefined"!=typeof job_manager_select2_filters_args&&e('select[name^="search_categories"]:visible').select2(job_manager_select2_filters_args),e(window).on("unload",(function(){return e("div.job_listings").each((function(){var t=o(e(this));t&&!t.persist_results&&function(e){if(!i(e))return!1;var t=o(e);t||(t={}),t.results=null,a(e,t)}(e(this))})),!0})),e("div.job_listings").each((function(){var t=e(this),n=t.find(".job_filters"),r=!1,d=o(t);d&&(d.results&&(r=l(t,d.results),s(t,!1),function(e){if(!i(e))return!1;var t=o(e);t||(t={}),t.form=null,a(e,t)}(t)),"string"==typeof d.form&&""!==d.form&&(n.find("input[type=checkbox]").prop("checked",!1),n.deserialize(d.form),n.find(':input[name^="search_categories"]').not(':input[type="hidden"]').trigger("change.select2"))),!r&&n.length>0&&t.triggerHandler("update_results",[1,!1])}))}));