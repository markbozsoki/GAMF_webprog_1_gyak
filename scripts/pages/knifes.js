window.lazyLoadOptions = [
    {
      elements_selector: "img[data-lazy-src],.rocket-lazyload",
      data_src: "lazy-src",
      data_srcset: "lazy-srcset",
      data_sizes: "lazy-sizes",
      class_loading: "lazyloading",
      class_loaded: "lazyloaded",
      threshold: 300,
      callback_loaded: function (element) {
        if (
          element.tagName === "IFRAME" &&
          element.dataset.rocketLazyload == "fitvidscompatible"
        ) {
          if (element.classList.contains("lazyloaded")) {
            if (typeof window.jQuery != "undefined") {
              if (jQuery.fn.fitVids) {
                jQuery(element).parent().fitVids();
              }
            }
          }
        }
      },
    },
    {
      elements_selector: ".rocket-lazyload",
      data_src: "lazy-src",
      data_srcset: "lazy-srcset",
      data_sizes: "lazy-sizes",
      class_loading: "lazyloading",
      class_loaded: "lazyloaded",
      threshold: 300,
    },
  ];
  
  window.addEventListener(
    "LazyLoad::Initialized",
    function (e) {
      var lazyLoadInstance = e.detail.instance;
  
      if (window.MutationObserver) {
        var observer = new MutationObserver(function (mutations) {
          var image_count = 0;
          var iframe_count = 0;
          var rocketlazy_count = 0;
  
          mutations.forEach(function (mutation) {
            for (var i = 0; i < mutation.addedNodes.length; i++) {
              var node = mutation.addedNodes[i];
  
              if (typeof node.getElementsByTagName !== "function") continue;
              if (typeof node.getElementsByClassName !== "function") continue;
  
              var images = node.getElementsByTagName("img");
              var iframes = node.getElementsByTagName("iframe");
              var rocket_lazy = node.getElementsByClassName("rocket-lazyload");
  
              var is_image = node.tagName === "IMG";
              var is_iframe = node.tagName === "IFRAME";
  
              image_count += images.length;
              iframe_count += iframes.length;
              rocketlazy_count += rocket_lazy.length;
  
              if (is_image) image_count += 1;
              if (is_iframe) iframe_count += 1;
            }
          });
  
          if (image_count > 0 || iframe_count > 0 || rocketlazy_count > 0) {
            lazyLoadInstance.update();
          }
        });
  
        var body = document.getElementsByTagName("body")[0];
        var config = { childList: true, subtree: true };
        observer.observe(body, config);
      }
    },
    false
  );
  