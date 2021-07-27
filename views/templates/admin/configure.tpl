{*
* 2007-2020 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2020 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="panel result">
	<div class="row moduleconfig-header">
		<div class="col-xs-5 text-right">
			<img src="{$module_dir|escape:'html':'UTF-8'}views/img/logo.svg" />
		</div>
		<div class="col-xs-7 text-left">
			<h2>{l s='Resultados' mod='trsearch'}</h2>
		</div>
	</div>
	<hr />
	<div class="moduleconfig-content">
		<div class="row">
			<div class="col-xs-12">
				<br />
									
							{if $invoice}
							
							<h3>{l s='Busqueda de factura' mod='trsearch'}</h3>
							
							<div class="blockSearch">
								{if !$order}
									{l s='Orden no encontrada' mod='trsearch'}
								{else}									
									<p class="text-center font-weight-bold">
									<strong>
									{l s='Id de pedido' mod='trsearch'} = {$order.id_order} | {l s='Ref de pedido' mod='trsearch'} = {$order.reference}
									</strong>	
									</p>
									<a class="btn btn-primary btn-sg btn-block" href="index.php?controller=AdminOrders&vieworder=&id_order= {$order.id_order}&token={Tools::getAdminTokenLite('AdminOrders')}" role="button">{l s='Ir al pedido' mod='trsearch'}</a>
								{/if}
							</div>
							
							{/if}
							{if $customerfound}
								<h3>{l s='Busqueda de cliente' mod='trsearch'}</h3>
								
								<div class="table-responsive blockSearch">
								{if !$name}
									{l s='Cliente no encontrado' mod='trsearch'}
								{else}
									<table class="table">
									<tr>
										<th>{l s='ID' mod='trsearch'}</th>
										<th>{l s='Nombre' mod='trsearch'}</th>
										<th>{l s='Apellido' mod='trsearch'}</th>
										<th>{l s='Email' mod='trsearch'}</th>
										<th>{l s='Telefono' mod='trsearch'}</th>
										<th>{l s='Ult. pedido' mod='trsearch'}</th>
										<th>{l s='Fecha' mod='trsearch'}</th>
										<th>{l s='Estado' mod='trsearch'}</th>
									</tr>
									{foreach from=$name item=item key=key name=name}
									
									<tr>
										<td><a href="index.php/sell/customers/{$item.id_customer}/view?{$token}">{$item.id_customer}</a></td>
										<td>{$item.firstname}</td>
										<td>{$item.lastname}</td>
										<td>{$item.email}</td>
										<td>{$item.phone}  {$item.phone_mobile}</td>
										<td>{if $item.id_order != "0"}
											<a href="index.php?controller=AdminOrders&vieworder=&id_order={$item.id_order}&token={Tools::getAdminTokenLite('AdminOrders')}">{$item.reference}</a>
										{/if}
										</td>
										<td>{$item.date}</td>
										<td>{$item.name}</td>
									</tr>
									
										
									{/foreach}
									</table>
								{/if}
								</div>	
								
							{/if}
							{if $product}
								<h3>{l s='Busqueda de artículo' mod='trsearch'}</h3>
								{if !$ref}
									{l s='Articulo no encontrado' mod='trsearch'}
								{else}
									<table class="table">
									<tr>
										<th>{l s='REF' mod='trsearch'}</th>
										<th>{l s='Articulo vendido' mod='trsearch'}</th>									
									</tr>									
									{foreach from=$ref item=item key=key name=name}
										<tr>
											<td><a href="index.php/sell/catalog/products/{$item.product_id}?{$token}">{$item.product_reference}</a></td>
											<td>{$item.product_name}</td>
										</tr>
									{/foreach}
									</table>
								{/if}
							{/if}
							
					
				
			</div>
		</div>
	</div>
</div>
