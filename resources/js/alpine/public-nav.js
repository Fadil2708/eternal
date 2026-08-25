export default (Alpine) => {
    Alpine.data('publicNav', () => ({
        navOpen: false,
        active: 'beranda',
        toggle() {
            this.navOpen = !this.navOpen;
            document.body.style.overflow = this.navOpen ? 'hidden' : '';
        },
        close() {
            if (!this.navOpen) return;
            this.navOpen = false;
            document.body.style.overflow = '';
        },
        init() {
            const ids = ['beranda', 'fitur', 'alur', 'untuk-siapa', 'tentang', 'faq'];
            const onScroll = () => {
                let current = ids[0];
                for (const id of ids) {
                    const el = document.getElementById(id);
                    if (el && el.getBoundingClientRect().top <= 160) {
                        current = id;
                    }
                }
                this.active = current;
            };
            onScroll();
            window.addEventListener('scroll', onScroll, { passive: true });
        }
    }));
};
