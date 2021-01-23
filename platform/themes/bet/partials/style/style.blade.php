<style>

.header-top {
    background: {{ theme_option('header_color') }};
}
.wrap-main {
    background: {{ theme_option('background_color') }};
}
.post-link {
    background: none !important;
}
.accordion-button:not(.collapsed) {
    background: #0000;
    color: #fff;
}
.accordion-button:focus {
    box-shadow: none;
    border-color: #000;
}
.post-link {
    color: #fff;
    font-weight: 500;
}
.feedback-item:focus, .feedback-item-wrap:focus {
    outline: none;
    box-shadow: none;
    border: none;
}
.slide-img img {
    width: 100%;
    height: auto;
    object-fit: cover;
}
.slide-img {
    height: auto;
    overflow: hidden;
}
.slide-img {
    height: auto;
    overflow: hidden;
}

.btn-search {
    background: {{ theme_option('primary_color') }}
}
.sub-menu-wrap {
    border: 2px solid {{ theme_option('primary_color') }};
}

.sub-menu-col .sub-menu .menu-link:hover {
    color: white;
    background: {{ theme_option('primary_color') }};
}
a:hover, .header-menu nav > ul > li:hover > a.menu-link {
    color: {{ theme_option('primary_color') }} !important;
}
.sub-menu-wrap a:hover {
    color: #fff !important
}
.sub-menu-col .sub-menu .sub-menu-header .menu-link {
    color: {{ theme_option('primary_color') }};
    font-weight: bold;
}
.sub-menu-wrap .sub-menu-col:not(:last-child) {
    border-right: 1px solid {{ theme_option('primary_color') }};
}
.menu-item.menu-item-has-children>.menu-link:before {
    content: '';
    width: 100%;
    height: 3px;
    position: absolute;
    bottom: 0;
    opacity: 0;
    visibility: hidden;
    transition: .5s ease-in-out;
    background: {{ theme_option('primary_color') }};
}

.menu-item.menu-item-has-children:hover .menu-link:after {
    color: {{ theme_option('primary_color') }};
}
.block-link {
    color: {{ theme_option('primary_color') }};
}
.block-link:hover {
    color: white;
    background: {{ theme_option('primary_color') }};
}

.post-link {
    color: {{ theme_option('primary_color') }};
}
.footer-1 {
    background: {{ theme_option('footer_color') }};
}
/* header_color_2 */
.header-menu {
    background: {{ theme_option('header_color_2') }}
}
.header-menu nav > ul > li > a.menu-link, .menu-item.menu-item-has-children>.menu-link:after {
    color: {{ theme_option('header_text_color_2') }};
}
.post--single .post__meta span {
    margin-right: 15px;
    color: #666;
}

.form-inline {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: horizontal;
    -webkit-box-direction: normal;
    -ms-flex-flow: row wrap;
    flex-flow: row wrap;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
}
.account-button-header .btn-account {
    padding: 8px 10px;
    margin: 0 5px;
}
.navbar {
    padding: 0 !important;
}
.account-button.account-button-sm a {
    margin: 5px 10px;
}
</style>
