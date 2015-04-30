/* Add detection for CSS @media states */

// Create the state-indicator element
var indicator = document.createElement('div');
indicator.className = 'media-type';
document.body.appendChild(indicator);
function getMediaType() {

  if (!window.getComputedStyle) {
    // @TODO Find IE8 polyfill; this temporarily alleviates the error
    return 'screen';
  }

  var index = parseInt(window.getComputedStyle(indicator).getPropertyValue('z-index'), 10),
      states = {
        1: 'screen',
        2: 'print'
      };

  return states[index] || 'screen';

}
function isPrint(){
  return getMediaType() == 'print';
}
function isScreen(){
  return getMediaType() == 'screen';
}
$(document).ready(function() {
    $('html').addClass('media-'+getMediaType());
});
