{*
 * Prestashop Facebook OpenGraph API module
 * Copyright (C) 2011 Miroslav Hruz, miroslav[dot]hruz[at]gmail[dot]com
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *}
 
<meta property="og:title" content="{$meta_title|escape:'htmlall':'UTF-8'}" />
{if $isProductPage == 1}
<meta property="og:type" content="product" />
{else}
<meta property="og:type" content="website" />
{/if} 
{if $isProductPage == 1}
<meta property="og:image" content="{$img_ps_dir}p/{$id_product}-{$id_image}-medium.jpg" />
{else}
<meta property="og:image" content="{$img_ps_dir}logo.jpg" />
{/if} 
<meta property="og:site_name" content="{$shop_name|escape:'htmlall':'UTF-8'}" />
<meta property="fb:admins" content="{$id_fb}" />
<meta property="og:description" content="{$meta_description|escape:html:'UTF-8'}" />

