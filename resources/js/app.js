import collapse from '@alpinejs/collapse';

import registerScrollProgress from './alpine/scroll-progress';
import registerAlertBar from './alpine/alert-bar';
import registerCookieConsent from './alpine/cookie-consent';
import registerPublicNav from './alpine/public-nav';
import registerHeroParallax from './alpine/hero-parallax';
import registerAnimatedCounter from './alpine/animated-counter';
import registerBackToTop from './alpine/back-to-top';
import registerToastStack from './alpine/toast-stack';
import registerPartnerMarquee from './alpine/partner-marquee';
import registerOfferSlider from './alpine/offer-slider';
import registerTestiCarousel from './alpine/testi-carousel';
import registerConfirmModal from './alpine/confirm-modal';

document.addEventListener('alpine:init', () => {
    window.Alpine.plugin(collapse);

    registerScrollProgress(window.Alpine);
    registerAlertBar(window.Alpine);
    registerCookieConsent(window.Alpine);
    registerPublicNav(window.Alpine);
    registerHeroParallax(window.Alpine);
    registerAnimatedCounter(window.Alpine);
    registerBackToTop(window.Alpine);
    registerToastStack(window.Alpine);
    registerPartnerMarquee(window.Alpine);
    registerOfferSlider(window.Alpine);
    registerTestiCarousel(window.Alpine);
    registerConfirmModal(window.Alpine);

    // Score calculator for evaluation form
    window.Alpine.data('scoreCalc', () => ({
        scores: { soft_skill: 75, hard_skill: 75, attendance: 75, attitude: 75 },
        finalScore: 75,
        grade: 'B',
        gradeClass: 'B',
        calc() {
            const s = this.scores;
            this.finalScore = Math.round(
                (s.soft_skill * 0.25) +
                (s.hard_skill * 0.35) +
                (s.attendance * 0.20) +
                (s.attitude * 0.20)
            );
            this.grade = this.finalScore >= 85 ? 'A'
                       : this.finalScore >= 70 ? 'B'
                       : this.finalScore >= 55 ? 'C' : 'D';
            this.gradeClass = this.grade;
        }
    }));

    // Timed hide for success messages (profile forms)
    window.Alpine.data('timedHide', () => ({
        show: true,
        init() {
            setTimeout(() => { this.show = false; }, 2000);
        }
    }));

    // Skill picker for intern profile
    window.Alpine.data('skillPicker', () => ({
        open: false,
        search: '',
        selected: [],
        allSkills: [],
        init(initialSkills, skillsList) {
            this.selected = initialSkills || [];
            this.allSkills = skillsList || [];
        },
        getName(id) {
            const s = this.allSkills.find(s => s.id == id);
            return s ? s.name : id;
        },
        removeSkill(id) {
            this.selected = this.selected.filter(s => s !== id);
            this.syncSelected();
        },
        sync(event) {
            this.syncSelected();
        },
        syncSelected() {
            this.$wire.set('selectedSkills', this.selected);
        }
    }));
});

// Global toast helper — callable from any JS code
window.showToast = function (message, type = 'success') {
    window.dispatchEvent(new CustomEvent('toast', { detail: { message, type } }));
};

// Scroll reveal — supports [data-reveal], [data-reveal-stagger], [data-reveal-left], [data-reveal-right]
document.addEventListener('DOMContentLoaded', () => {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                el.classList.add('revealed');
                observer.unobserve(el);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll(
        '[data-reveal], [data-reveal-left], [data-reveal-right], [data-reveal-stagger]'
    ).forEach(el => observer.observe(el));
});
