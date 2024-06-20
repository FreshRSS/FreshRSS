(function() {
    'use strict';
    console.log("ThreePanesView FreshRSS extension detected");

    var _load = function()
    {
        if (!window.context) {
            console.log("ThreePanesView FreshRSS extension waiting for FreshRSS to be initialized");
            window.setTimeout(_load, 100);
            return;
        }

        // Only enable for normal display mode
        if (window.context.current_view !== "normal" || window.innerWidth < 800)
            return;

        var stream = document.getElementById("stream");
        var content = stream.querySelector(".flux.current");
        var html = content ? content.querySelector(".flux_content").innerHTML : "";
        stream.insertAdjacentHTML("beforebegin", `<div id="threepanesviewcontainer"></div>`);
        var wrapper = document.getElementById("threepanesviewcontainer");
        wrapper.appendChild(stream);
        wrapper.insertAdjacentHTML("beforeend", `<div id="threepanesview"><div class="flux">${html}</div></div>`);

        // Set event listeners on the new panel (ex: click events to display labels, etc.)
        init_stream(document.getElementById("threepanesview"));

        // The document will not receive scroll events anymore (since the height equals 100%), so we
        // set the stream node as the bow to follow and we re-dispatch it to the window.
        box_to_follow = document.getElementById("stream");
        document.getElementById("stream").addEventListener("scroll", function(event) {
            window.dispatchEvent(new UIEvent(event.type, event))
        });

        var _resize = function()
        {
            var topOffset = wrapper.offsetTop;

            // Some CSS is not loaded yet
            if (topOffset > 500)
                window.setTimeout(_resize, 10);
            else
            {
                var availableHeight = window.innerHeight - topOffset;
                wrapper.style.height = `${availableHeight}px`;

                // Also set the height for the menu.
                var menuForm = document.getElementById("mark-read-aside");
                var navEntries = document.getElementById("nav_entries");

                if (menuForm)
                    availableHeight -= menuForm.previousElementSibling.clientHeight;

                // Might not exist on the labels view for ex.
                if (navEntries)
                    availableHeight -= navEntries.clientHeight;

                menuForm.style.height = `${availableHeight}px`;
            }

        };
        _resize();
        window.addEventListener("resize", _resize);

        var panel = document.getElementById("threepanesview");
        var panelContent = panel.querySelector(".flux");
        var setContent = function(html, articleId)
        {
            // Check the container has the expected height (which can sometimes be removed by
            //something else).
            if (!(wrapper.getAttribute("style") || "").includes("height"))
                _resize();

            panelContent.innerHTML = html;

            // Duplicate the id attribute so that it can be retrieve by other functions
            panelContent.setAttribute("id", articleId);

            // Scroll to top of panel
            panel.scrollTop = 0;
        };

        var onArticleOpened = function(articleElement) {
            // Make the new article visible if out of scroll.
            articleElement.scrollIntoView({
                block: "nearest",
                inline: "nearest",
                scrollMode: "if-needed"
            });

            var articleId = articleElement.getAttribute("id");
            var articleContent = articleElement.querySelector(".flux_content").innerHTML;

            // Each skin might have a different background color for the content than the #global
            // node which is the parent they share with this extension container.
            // As  we want to keep the same display, we need to copy it.
            // We also want it to be applied on hover, so we create a scoped CSS style instead of
            // applying it directly to the style attribute.
            var contentStyles = window.getComputedStyle(articleElement);            
            
            // Use "!important" since some themes use it… Also use a prefix with the article id
            // since scoped styles are not supported by every browser.
           articleContent = `<style scoped>
                #threepanesview > #${articleId},
                #threepanesview > #${articleId}:hover
                {
                    background-color: ${contentStyles.backgroundColor} !important;
                    background-image: ${contentStyles.backgroundImage} !important;
                    color: ${contentStyles.color} !important;
                }
            </style>
            ${articleContent}
            `;

            setContent(articleContent, articleId);

            // We need to replace every id (and reference to it) by a new one to avoid duplicates.
            panelContent.querySelectorAll("[id]").forEach(function(node) {
                let ref = node.getAttribute("id");

                if (!ref)
                    return;

                let newRef = `3panes-${ref}`;

                // Set a new id value.
                node.setAttribute("id", newRef);

                // Update all references to it.
                panelContent.querySelectorAll(`[href="#${ref}"]`).forEach(function(elt) {
                    elt.setAttribute("href", `#${newRef}`);
                });
            });
        };

        document.addEventListener('freshrss:openArticle', function(event) {
            onArticleOpened(event.target);
        });

        stream.addEventListener("click", function(event) {
            // Open external links in the 3rd pane too.
            if (event.target.matches(".flux li.link *") && !event.ctrlKey)
            {
                event.preventDefault();

                var link = event.target.closest("a");
                var url = link ? link.getAttribute("href") : "";
                if (url) {
                    setContent(`<iframe src="${url}"></iframe>`);
                }

                return;
            }

            // Legacy: deal with older FreshRSS versions without 'openArticle' event.
            // Do not use `window.freshrssOpenArticleEvent`, it is not available on `window` since
            // https://github.com/FreshRSS/FreshRSS/commit/b438d8bb3d4b3dea6d28d0b0c73da9393c9d8299#diff-86db6bc50f24e839f927bdd2262ce6d58c450fb23b13f8e9e5501b047add9bba
            if (typeof freshrssOpenArticleEvent === "undefined") {
                var closestArticle = event.target.closest(".flux");

                if (closestArticle && stream.contains(closestArticle))
                    onArticleOpened(closestArticle);
            }
        });
    };

    if (document.readyState === "loading") {
        window.addEventListener("load", _load);
    } else {
        _load();
    }
}());
