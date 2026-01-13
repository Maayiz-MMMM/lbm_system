document.addEventListener('DOMContentLoaded', () => {

    // Helper: safely attach click events
    const safeAddListener = (id, callback) => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('click', callback);
    };

    // ----------------------------
    // Standard alerts
    // ----------------------------
    safeAddListener('basic', () =>
        Swal.fire('Any fool can use a computer')
    );

    safeAddListener('footer', () =>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
            footer: '<a href="#">Why do I have this issue?</a>'
        })
    );

    safeAddListener('title', () =>
        Swal.fire('The Internet?', 'That thing is still around?', 'question')
    );

    safeAddListener('success', () =>
        Swal.fire({ icon: 'success', title: 'Success' })
    );

    safeAddListener('error', () =>
        Swal.fire({ icon: 'error', title: 'Error' })
    );

    safeAddListener('warning', () =>
        Swal.fire({ icon: 'warning', title: 'Warning' })
    );

    safeAddListener('info', () =>
        Swal.fire({ icon: 'info', title: 'Info' })
    );

    safeAddListener('question', () =>
        Swal.fire({ icon: 'question', title: 'Question' })
    );

    // ----------------------------
    // Input alerts
    // ----------------------------
    safeAddListener('text', () =>
        Swal.fire({
            title: 'Enter your IP address',
            input: 'text',
            inputLabel: 'Your IP address',
            showCancelButton: true
        })
    );

    safeAddListener('email', async () => {
        const { value } = await Swal.fire({
            title: 'Input email address',
            input: 'email',
            inputLabel: 'Your email address',
            inputPlaceholder: 'Enter your email address'
        });
        if (value) Swal.fire(`Entered email: ${value}`);
    });

    safeAddListener('url', async () => {
        const { value } = await Swal.fire({
            input: 'url',
            inputLabel: 'URL address',
            inputPlaceholder: 'Enter the URL'
        });
        if (value) Swal.fire(`Entered URL: ${value}`);
    });

    // ✅ FIXED: renamed ID so it DOES NOT conflict with form password input
    safeAddListener('swal_password_demo', async () => {
        const { value } = await Swal.fire({
            title: 'Enter your password',
            input: 'password',
            inputLabel: 'Password',
            inputPlaceholder: 'Enter your password',
            inputAttributes: {
                maxlength: 10,
                autocapitalize: 'off',
                autocorrect: 'off'
            }
        });
        if (value) Swal.fire('Password received');
    });

    safeAddListener('textarea', async () => {
        const { value } = await Swal.fire({
            input: 'textarea',
            inputLabel: 'Message',
            inputPlaceholder: 'Type your message here...',
            showCancelButton: true
        });
        if (value) Swal.fire(value);
    });

    safeAddListener('select', async () => {
        const { value } = await Swal.fire({
            title: 'Select field validation',
            input: 'select',
            inputOptions: {
                Fruits: {
                    apples: 'Apples',
                    bananas: 'Bananas',
                    grapes: 'Grapes',
                    oranges: 'Oranges'
                }
            },
            inputPlaceholder: 'Select a fruit',
            showCancelButton: true,
            inputValidator: (value) =>
                value === 'oranges'
                    ? undefined
                    : 'You need to select oranges 🙂'
        });

        if (value) Swal.fire(`You selected: ${value}`);
    });

});
