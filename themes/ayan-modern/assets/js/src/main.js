const prefersReducedMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
const strings = window.ayanModernI18n || {};

function initThemeReady() {
	document.documentElement.classList.add( 'ayan-theme-ready' );
}

function initSmoothAnchors() {
	if ( prefersReducedMotion ) {
		return;
	}

	document.querySelectorAll( 'a[href^="#"]' ).forEach( ( anchor ) => {
		anchor.addEventListener( 'click', ( event ) => {
			const hash = anchor.getAttribute( 'href' );
			if ( ! hash || hash === '#' ) {
				return;
			}

			let target;
			try {
				target = document.querySelector( hash );
			} catch ( error ) {
				return;
			}

			if ( ! target ) {
				return;
			}

			event.preventDefault();
			target.scrollIntoView( { behavior: 'smooth', block: 'start' } );
		} );
	} );
}

function initStickyHeader() {
	const header = document.querySelector( '.site-header' );
	if ( ! header ) {
		return;
	}

	const updateHeader = () => header.classList.toggle( 'is-scrolled', window.scrollY > 24 );
	updateHeader();
	window.addEventListener( 'scroll', updateHeader, { passive: true } );
}

function initReadingProgress() {
	if ( ! document.body.classList.contains( 'single-post' ) ) {
		return;
	}

	const progress = document.createElement( 'div' );
	progress.className = 'reading-progress';
	progress.setAttribute( 'aria-hidden', 'true' );
	document.body.appendChild( progress );

	const article = document.querySelector( '.site-main--single .wp-block-post-content, .site-main--single' );
	if ( ! article ) {
		return;
	}

	const updateProgress = () => {
		const rect = article.getBoundingClientRect();
		const scrollableHeight = article.offsetHeight - window.innerHeight;
		const progressRatio = scrollableHeight > 0 ? Math.min( Math.max( -rect.top, 0 ), scrollableHeight ) / scrollableHeight : 0;
		progress.style.transform = `scaleX(${ progressRatio })`;
	};

	updateProgress();
	window.addEventListener( 'scroll', updateProgress, { passive: true } );
	window.addEventListener( 'resize', updateProgress );
}

function initBackToTop() {
	const button = document.createElement( 'button' );
	button.type = 'button';
	button.className = 'back-to-top';
	button.setAttribute( 'aria-label', strings.backToTop || 'Back to top' );
	button.hidden = true;
	button.textContent = strings.top || 'Top';
	document.body.appendChild( button );

	const footer = document.querySelector( '.site-footer' );
	const updateVisibility = () => {
		button.hidden = window.scrollY < 480 || ( footer && footer.getBoundingClientRect().top < window.innerHeight );
	};

	button.addEventListener( 'click', () => window.scrollTo( { top: 0, behavior: prefersReducedMotion ? 'auto' : 'smooth' } ) );
	updateVisibility();
	window.addEventListener( 'scroll', updateVisibility, { passive: true } );
	window.addEventListener( 'resize', updateVisibility );
}

function copyText( text ) {
	if ( navigator.clipboard && window.isSecureContext ) {
		return navigator.clipboard.writeText( text ).catch( () => copyTextWithCommand( text ) );
	}

	return copyTextWithCommand( text );
}

function copyTextWithCommand( text ) {
	const input = document.createElement( 'textarea' );
	input.value = text;
	input.setAttribute( 'readonly', '' );
	input.style.position = 'fixed';
	input.style.opacity = '0';
	document.body.appendChild( input );
	input.select();

	const copied = document.execCommand( 'copy' );
	input.remove();
	return copied ? Promise.resolve() : Promise.reject( new Error( 'Copy command failed' ) );
}

function initShareRow() {
	const row = document.querySelector( '.share-row' );
	if ( ! row ) {
		return;
	}

	const url = encodeURIComponent( window.location.href );
	const title = encodeURIComponent( document.title );
	row.querySelectorAll( '[data-share="x"]' ).forEach( ( link ) => {
		link.href = `https://twitter.com/intent/tweet?url=${ url }&text=${ title }`;
	} );
	row.querySelectorAll( '[data-share="linkedin"]' ).forEach( ( link ) => {
		link.href = `https://www.linkedin.com/sharing/share-offsite/?url=${ url }`;
	} );

	row.querySelectorAll( '[data-share="copy"], .share-copy' ).forEach( ( button ) => {
		button.addEventListener( 'click', async () => {
			const status = row.querySelector( '.share-copy-status' );
			try {
				await copyText( window.location.href );
				if ( status ) {
					status.textContent = strings.copySuccess || 'Link copied.';
				}
			} catch ( error ) {
				if ( status ) {
					status.textContent = strings.copyFailed || 'Copy failed. Select and copy the link manually.';
				}
			}
		} );
	} );
}

function initFeaturedImageMotion() {
	if ( prefersReducedMotion ) {
		return;
	}

	document.querySelectorAll( '.featured-image--scale, .is-style-full-bleed' ).forEach( ( element ) => {
		element.classList.add( 'is-motion-ready' );
	} );
}

function boot() {
	initThemeReady();
	initSmoothAnchors();
	initStickyHeader();
	initReadingProgress();
	initBackToTop();
	initShareRow();
	initFeaturedImageMotion();
}

if ( document.readyState === 'loading' ) {
	document.addEventListener( 'DOMContentLoaded', boot );
} else {
	boot();
}
