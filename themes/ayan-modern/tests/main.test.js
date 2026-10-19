const { beforeEach, afterEach, test } = require( 'node:test' );
const assert = require( 'node:assert/strict' );
const { readFileSync } = require( 'node:fs' );
const { JSDOM } = require( 'jsdom' );

const source = readFileSync( require.resolve( '../assets/js/src/main' ), 'utf8' );
const shareRow = () => `
	<div class="share-row">
		<a data-share="x" href="#">X</a>
		<a data-share="linkedin" href="#">LinkedIn</a>
		<button class="share-copy" data-share="copy">Copy link</button>
		<span class="share-copy-status" role="status"></span>
	</div>`;

let dom, window, document, clipboard, copyCalls, commandCalls;
const settle = () => new Promise( ( resolve ) => setImmediate( resolve ) );
const boot = () => window.eval( source );
const statusText = () => document.querySelector( '[role="status"]' ).textContent;

beforeEach( () => {
	dom = new JSDOM( shareRow() + shareRow(), {
		url: 'https://example.test/notes/?q=hello&lang=en',
		runScripts: 'outside-only',
	} );
	window = dom.window;
	document = window.document;
	document.title = 'Notes & ideas';
	Object.defineProperty( document, 'readyState', { value: 'complete' } );
	Object.defineProperty( window, 'isSecureContext', { configurable: true, value: true } );
	window.matchMedia = () => ( { matches: false } );
	copyCalls = [];
	commandCalls = [];
	clipboard = { writeText: async ( text ) => { copyCalls.push( text ); } };
	Object.defineProperty( window.navigator, 'clipboard', { configurable: true, value: clipboard } );
	document.execCommand = ( command ) => { commandCalls.push( command ); return true; };
} );

afterEach( () => dom.window.close() );

test( 'initializes sharing links and copy actions in every row', async () => {
	boot();
	for ( const row of document.querySelectorAll( '.share-row' ) ) {
		const x = new URL( row.querySelector( '[data-share="x"]' ).href );
		const linkedin = new URL( row.querySelector( '[data-share="linkedin"]' ).href );
		assert.equal( x.searchParams.get( 'url' ), window.location.href );
		assert.equal( x.searchParams.get( 'text' ), document.title );
		assert.equal( linkedin.searchParams.get( 'url' ), window.location.href );
		row.querySelector( 'button' ).click();
		await settle();
		assert.equal( row.querySelector( '[role="status"]' ).textContent, 'Link copied.' );
	}
	assert.deepEqual( copyCalls, [ window.location.href, window.location.href ] );
} );

test( 'falls back when the Clipboard API rejects', async () => {
	clipboard.writeText = async () => { throw new Error( 'Permission denied' ); };
	boot();
	const button = document.querySelector( '.share-copy' );
	button.focus();
	button.click();
	await settle();
	assert.deepEqual( commandCalls, [ 'copy' ] );
	assert.equal( document.querySelector( 'textarea' ), null );
	assert.equal( document.activeElement, button );
	assert.equal( statusText(), 'Link copied.' );
} );

for ( const condition of [ 'unavailable', 'insecure' ] ) {
	test( `uses fallback when clipboard is ${ condition }`, async () => {
		if ( condition === 'unavailable' ) {
			Object.defineProperty( window.navigator, 'clipboard', { value: undefined } );
		} else {
			Object.defineProperty( window, 'isSecureContext', { value: false } );
		}
		boot();
		document.querySelector( '.share-copy' ).click();
		await settle();
		assert.deepEqual( commandCalls, [ 'copy' ] );
		assert.equal( copyCalls.length, 0 );
		assert.equal( statusText(), 'Link copied.' );
	} );
}

for ( const failure of [ 'returns false', 'throws' ] ) {
	test( `cleans up and restores focus when fallback ${ failure }`, async () => {
		Object.defineProperty( window.navigator, 'clipboard', { value: undefined } );
		document.execCommand = () => {
			if ( failure === 'throws' ) {
				throw new Error( 'Unsupported copy command' );
			}
			return false;
		};
		boot();
		const button = document.querySelector( '.share-copy' );
		button.focus();
		button.click();
		await settle();
		assert.equal( document.querySelector( 'textarea' ), null );
		assert.equal( document.activeElement, button );
		assert.match( statusText(), /Copy failed\./ );

		// A failed attempt must not block a later successful retry.
		document.execCommand = () => true;
		button.click();
		await settle();
		assert.equal( statusText(), 'Link copied.' );
	} );
}

test( 'ignores repeated clicks while copying and clears stale feedback on retry', async () => {
	let resolveCopy;
	clipboard.writeText = ( text ) => {
		copyCalls.push( text );
		return new Promise( ( resolve ) => { resolveCopy = resolve; } );
	};
	window.ayanModernI18n = { copySuccess: 'Copied successfully' };
	boot();
	const button = document.querySelector( '.share-copy' );
	const status = document.querySelector( '[role="status"]' );
	status.textContent = 'Previous result';
	button.click();
	button.click();
	assert.equal( status.textContent, '' );
	assert.equal( copyCalls.length, 1 );
	resolveCopy();
	await settle();
	assert.equal( status.textContent, 'Copied successfully' );
	button.click();
	assert.equal( status.textContent, '' );
	resolveCopy();
	await settle();
} );

test( 'leaves fragment navigation to the browser, including modified clicks and unusual IDs', () => {
	document.body.innerHTML = '<a href="#chapter">Chapter</a><h2 id="chapter">Chapter</h2>';
	boot();
	const anchor = document.querySelector( 'a' );
	for ( const id of [ 'chapter', 'chapter:1', '123', 'café' ] ) {
		document.querySelector( 'h2' ).id = id;
		anchor.setAttribute( 'href', `#${ encodeURIComponent( id ) }` );
		for ( const options of [ {}, { ctrlKey: true }, { metaKey: true } ] ) {
			const event = new window.MouseEvent( 'click', { bubbles: true, cancelable: true, ...options } );
			anchor.dispatchEvent( event );
			assert.equal( event.defaultPrevented, false );
		}
	}
} );
