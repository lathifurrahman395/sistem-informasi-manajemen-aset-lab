(function () {
    // ===== 1) Progress bar tipis di atas =====
    const bar = document.createElement('div');
    bar.id = 'fi-progress-bar';
    document.addEventListener('DOMContentLoaded', () => document.body.appendChild(bar));

    // ===== 2) Skeleton loading overlay =====
    const skeletonHTML = `
        <div class="fi-skeleton fi-skel-title"></div>
        <div class="fi-skel-cards">
            <div class="fi-skeleton fi-skel-card"></div>
            <div class="fi-skeleton fi-skel-card"></div>
            <div class="fi-skeleton fi-skel-card"></div>
        </div>
        <div class="fi-skeleton fi-skel-row"></div>
        <div class="fi-skeleton fi-skel-row"></div>
        <div class="fi-skeleton fi-skel-row"></div>
        <div class="fi-skeleton fi-skel-row"></div>
        <div class="fi-skeleton fi-skel-row"></div>
    `;

    let skeletonEl = null;

    function showSkeleton() {
        const main = document.querySelector('.fi-main');
        if (!main) return;

        const rect = main.getBoundingClientRect();

        if (!skeletonEl) {
            skeletonEl = document.createElement('div');
            skeletonEl.className = 'fi-skeleton-wrap';
            skeletonEl.innerHTML = skeletonHTML;
            document.body.appendChild(skeletonEl);
        }

        skeletonEl.style.top = rect.top + 'px';
        skeletonEl.style.left = rect.left + 'px';
        skeletonEl.style.width = rect.width + 'px';
        skeletonEl.style.height = rect.height + 'px';

        requestAnimationFrame(() => skeletonEl.classList.add('active'));
    }

    function hideSkeleton() {
        if (!skeletonEl) return;
        skeletonEl.classList.remove('active');
        setTimeout(() => {
            skeletonEl?.remove();
            skeletonEl = null;
        }, 250);
    }

    // ===== 3) Retrigger animasi wipe pada konten baru =====
    function replayAnimation(el, className) {
        if (!el) return;
        el.classList.remove(className);
        void el.offsetWidth;
        el.classList.add(className);
    }

})();