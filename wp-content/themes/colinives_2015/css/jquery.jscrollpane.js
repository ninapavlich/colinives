/*
 * CSS Styles that are needed by jScrollPane for it to operate correctly.
 *
 * Include this stylesheet in your site or copy and paste the styles below into your stylesheet - jScrollPane
 * may not operate correctly without them.
 */

.jspContainer
{
	overflow: hidden;
	position: relative;
}

.jspPane
{
	position: absolute;
}

.jspVerticalBar
{
	position: absolute;
	top: 0;
	right: 0;
	width: 16px;
	height: 100%;
	background: red;
}

.jspHorizontalBar
{
	position: absolute;
	bottom: 0;
	left: 0;
	width: 100%;
	height: 16px;
	background: red;
}

.jspVerticalBar *,
.jspHorizontalBar *
{
	margin: 0;
	padding: 0;
}

.jspCap
{
	display: none;
}

.jspHorizontalBar .jspCap
{
	float: left;
}

.jspTrack
{
	background: #dde;
	position: relative;
}

.jspDrag
{
	background: #bbd;
	position: relative;
	top: 0;
	left: 0;
	cursor: pointer;
}

.jspHorizontalBar .jspTrack,
.jspHorizontalBar .jspDrag
{
	float: left;
	height: 100%;
}

.jspArrow
{
	background: #50506d;
	text-indent: -20000px;
	display: block;
	cursor: pointer;
}

.jspArrow.jspDisabled
{
	cursor: default;
	background: #80808d;
}

.jspVerticalBar .jspArrow
{
	height: 16px;
}

.jspHorizontalBar .jspArrow
{
	width: 16px;
	float: left;
	height: 100%;
}

.jspVerticalBar .jspArrow:focus
{
	outline: none;
}

.jspCorner
{
	background: #eeeef4;
	float: left;
	height: 100%;
}

/* Yuk! CSS Hack for IE6 3 pixel bug :( */
* html .jspCorner
{
	margin: 0 -3px 0 0;
}


/* CUSTOMIZATIONS	*/
/*
SCROLL BAR STYLES
*/
.scroll-pane
{
	width: 100%;
	height: 300px;
	overflow: auto;
}

.horizontal-only
{
	height: auto;
	max-height: 300px;
}
.jspVerticalBar {
	width: 8px;
	
}
.jspTrack{
	background: none repeat scroll 0 0 #ffffff;
}
.jspDrag{
	background: none repeat scroll 0 0 #eeeeee;
}
.jspArrow{
	background: none repeat scroll 0 0 #eeeeee;
}
.jspArrow.jspDisabled{
	background: none repeat scroll 0 0 #cccccc;
}
