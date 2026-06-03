<script>
    const progressWidths = { 1: '0%', 2: '50%', 3: '100%' };

    function updateStepMarkers(activeStep) {
        for (let i = 1; i <= 3; i++) {
            const marker = document.getElementById(`step-marker-${i}`);
            const label = document.getElementById(`step-label-${i}`);

            if (! marker || ! label) {
                continue;
            }

            if (i <= activeStep) {
                marker.classList.remove('bg-surface-variant', 'text-on-surface-variant');
                marker.classList.add('bg-primary', 'text-on-primary');
                label.classList.remove('text-on-surface-variant');
                label.classList.add('text-primary');
            } else {
                marker.classList.remove('bg-primary', 'text-on-primary');
                marker.classList.add('bg-surface-variant', 'text-on-surface-variant');
                label.classList.remove('text-primary');
                label.classList.add('text-on-surface-variant');
            }
        }
    }

    function nextStep(step) {
        if (step === 2) {
            const eventType = document.getElementById('event-type-input')?.value;
            if (! eventType) {
                alert('Please select an event type.');
                return;
            }
        }

        for (let i = 1; i <= 3; i++) {
            document.getElementById(`step-${i}`)?.classList.toggle('hidden', i !== step);
        }

        const progressBar = document.getElementById('progress-bar');
        if (progressBar) {
            progressBar.style.width = progressWidths[step];
        }

        updateStepMarkers(step);
    }

    document.querySelectorAll('.intake-event-choice').forEach((button) => {
        button.addEventListener('click', () => {
            document.getElementById('event-type-input').value = button.dataset.eventType;
            nextStep(2);
        });
    });

    document.querySelectorAll('.theme-swatch').forEach((button) => {
        button.addEventListener('click', () => {
            document.getElementById('theme-color-input').value = button.dataset.color;
            document.getElementById('custom-hex').value = button.dataset.color;
            document.querySelectorAll('.theme-swatch').forEach((swatch) => {
                swatch.classList.remove('ring-4');
                swatch.classList.add('ring-2');
            });
            button.classList.remove('ring-2');
            button.classList.add('ring-4');
        });
    });

    document.getElementById('custom-hex')?.addEventListener('input', (event) => {
        document.getElementById('theme-color-input').value = event.target.value;
    });

    if (document.getElementById('intake-form-element')?.dataset.hasErrors === '1') {
        nextStep(3);
    }
</script>
