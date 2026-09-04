if (document.readyState && document.readyState !== 'loading') {
    documentReady();
} else {
    document.addEventListener('DOMContentLoaded', async () => await documentReady(), false);
}

async function documentReady() {
    attachHoarderIntegrationListeners();

    document.body.addEventListener('freshrss:load-more', function () {
        console.log('freshrss:load-more');
        attachHoarderIntegrationListeners();
    });

    if (hoarder_Integration_vars.keyboard_shortcut) {
        document.addEventListener('keydown', (e) => {
            if (e.ctrlKey || e.metaKey || e.altKey || e.shiftKey || e.target.closest('input, textarea')) return;
            if (e.key === hoarder_Integration_vars.keyboard_shortcut) {
                const active = document.querySelector("#stream .flux.active");
                if (!active) return;

                const button = active.querySelector("a.hoarderIntegration");
                if (!button) return;

                button.click();
            }
        });
    }
}

function attachHoarderIntegrationListeners() {
    document.querySelectorAll('#stream .flux a.hoarderIntegration').forEach(button => {
        button.addEventListener('click', async (e) => {
            e.preventDefault();

            const url = button.getAttribute('data-url');
            const csrfToken = context.csrf;

            if (!url) return;

            button.disabled = true;


            let buttonImg = button.querySelector("img");
            let loadingAnimation = button.querySelector(".lds-dual-ring");
            if (buttonImg) buttonImg.classList.add("disabled");
            if (loadingAnimation) loadingAnimation.classList.remove("disabled");

            try {

                const response = await fetch('/freshrss/p/i/?c=hoarderIntegration&a=add', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        url: url,
                        _csrf: csrfToken
                    })
                });

                if (response.ok) {
                    const responseData = await response.json(); 
                    console.log('Bookmark added successfully:', responseData);
                    if (buttonImg) buttonImg.setAttribute("src", hoarder_Integration_vars.icons.bookmark_added);
                    openNotification(hoarder_Integration_vars.i18n.added_bookmark.replace('%s', responseData.response.content.url), 'hoarder_button_good');
                } else {
                    const errorData = await response.json();
                    console.error('Failed to add bookmark:', errorData.message);
                    openNotification(hoarder_Integration_vars.i18n.failed_to_add_bookmark.replace('%s', errorData.message), 'hoarder_button_bad');
                }
            } catch (error) {
                console.error('Error:', error);
                openNotification(hoarder_Integration_vars.i18n.ajax_request_failed, 'hoarder_button_bad');
            } finally {
                button.disabled = false;
                if (buttonImg) buttonImg.classList.remove("disabled");
                if (loadingAnimation) loadingAnimation.classList.add("disabled");
            }
        });
    });
}
