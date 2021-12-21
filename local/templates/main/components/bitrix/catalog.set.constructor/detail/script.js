BX.namespace("BX.Catalog.SetConstructor");

BX.Catalog.SetConstructor = (function()
{
	var SetConstructor = function(params)
	{
		this.numSliderItems = params.numSliderItems || 0;
		this.numSetItems = params.numSetItems || 0;
		this.jsId = params.jsId || "";
		this.ajaxPath = params.ajaxPath || "";
		this.currency = params.currency || "";
		this.lid = params.lid || "";
		this.iblockId = params.iblockId || "";
		this.basketUrl = params.basketUrl || "";
		this.setIds = params.setIds || null;
		this.offersCartProps = params.offersCartProps || null;
		this.itemsRatio = params.itemsRatio || null;
		this.noFotoSrc = params.noFotoSrc || "";
		this.messages = params.messages;

		this.canBuy = params.canBuy;
		this.mainElementPrice = params.mainElementPrice || 0;
		this.mainElementOldPrice = params.mainElementOldPrice || 0;
		this.mainElementDiffPrice = params.mainElementDiffPrice || 0;
		this.mainElementBasketQuantity = params.mainElementBasketQuantity || 1;

		this.parentCont = BX(params.parentContId) || null;
		this.sliderParentCont = this.parentCont.querySelector("[data-role='slider-parent-container']");
		this.sliderItemsCont = this.parentCont.querySelector("[data-role='set-other-items']");
		this.setItemsCont = this.parentCont.querySelector("[data-role='set-items']");

		this.setPriceCont = this.parentCont.querySelector("[data-role='set-price']");
		//this.setPriceDuplicateCont = this.parentCont.querySelector("[data-role='set-price-duplicate']");
		this.setOldPriceCont = this.parentCont.querySelector("[data-role='set-old-price']");
		//this.setOldPriceRow = this.setOldPriceCont.parentNode.parentNode;
		//this.setDiffPriceCont = this.parentCont.querySelector("[data-role='set-diff-price']");
		//this.setDiffPriceRow = this.setDiffPriceCont.parentNode.parentNode;

		//this.notAvailProduct = this.sliderItemsCont.querySelector("[data-not-avail='yes']");

		//this.emptySetMessage = this.parentCont.querySelector("[data-set-message='empty-set']");

		BX.bindDelegate(this.setItemsCont, 'click', {'attribute': 'data-role' }, BX.proxy(this.deleteFromSet, this));
		BX.bindDelegate(this.setItemsCont, 'click', { 'attribute': 'data-role' }, BX.proxy(this.addToSet, this));

		var buyButton = this.parentCont.querySelector("[data-role='set-buy-btn']");
		if (this.canBuy)
		{
			BX.show(buyButton);
			BX.bind(buyButton, "click", BX.proxy(this.addToBasket, this));
		}
		else
		{
			BX.hide(buyButton);
		}

		this.generateSliderStyles();
	};

	SetConstructor.prototype.generateSliderStyles = function()
	{
		var styleNode = BX.create("style", {
			html:	".bx-catalog-set-topsale-slids-"+this.jsId+"{width: " + this.numSliderItems*25 + "%;}"+
					".bx-catalog-set-item-container-"+this.jsId+"{width: " + (100/this.numSliderItems) + "%;}"+
					"@media (max-width:767px){"+
					".bx-catalog-set-topsale-slids-"+this.jsId+"{width: " + this.numSliderItems*20*2 + "%;}}",
			attrs: {
				id: "bx-set-const-style-" + this.jsId
			}});

		if (BX("bx-set-const-style-" + this.jsId))
		{
			BX.remove(BX("bx-set-const-style-" + this.jsId));
		}

		this.parentCont.appendChild(styleNode);
	};

	SetConstructor.prototype.addToSet = function()
	{
		var target = BX.proxy_context,
			item,
			itemId;
		if (!!target && target.hasAttribute('data-role') && target.getAttribute('data-role') == 'set-add-btn')
		{
			item = target.parentNode.parentNode.parentNode;
			itemId = item.getAttribute("data-id");
			item.setAttribute("data-active", 'Y');
			target.parentNode.classList.add('active');
			target.setAttribute("data-role", 'set-delete-btn');
			this.setIds.push(+itemId);
			this.recountPrice();
		}
		else
		{
			target.setAttribute("data-role", 'set-add-btn');
		}
	};

	SetConstructor.prototype.deleteFromSet = function()
	{
		var target = BX.proxy_context,
			item,
			itemId;
		if (target && target.hasAttribute('data-role') && target.getAttribute('data-role') == 'set-delete-btn')
		{
			item = target.parentNode.parentNode.parentNode;
			itemId = item.getAttribute("data-id");
			item.setAttribute("data-active", 'N');
			target.parentNode.classList.remove('active');
			for (i = 0, l = this.setIds.length; i < l; i++)
			{
				if (this.setIds[i] == itemId)
					this.setIds.splice(i, 1);
			}
			this.recountPrice();
		}

	};

	/*SetConstructor.prototype.deleteFromSet = function()
	{
		var target = BX.proxy_context,
			item,
			itemId,
			itemName,
			itemUrl,
			itemImg,
			itemPrintPrice,
			itemPrice,
			itemPrintOldPrice,
			itemOldPrice,
			itemDiffPrice,
			itemMeasure,
			itemBasketQuantity,
			i,
			l,
			newSliderNode,
			itemCount,
			itemActive;

		if (target && target.hasAttribute('data-role') && target.getAttribute('data-role') == 'set-delete-btn')
		{
			item = target.parentNode.parentNode.parentNode;
			itemDel = item.parentNode.parentNode.parentNode;
			itemId = item.getAttribute("data-id");
			itemCount = item.getAttribute("data-count");
			itemActive = item.getAttribute("data-active");
			itemName = item.getAttribute("data-name");
			itemUrl = item.getAttribute("data-url");
			itemImg = item.getAttribute("data-img");
			itemPrintPrice = item.getAttribute("data-print-price");
			itemPrice = item.getAttribute("data-price");
			itemPrintOldPrice = item.getAttribute("data-print-old-price");
			itemOldPrice = item.getAttribute("data-old-price");
			itemDiffPrice = item.getAttribute("data-diff-price");
			itemMeasure = item.getAttribute("data-measure");
			itemBasketQuantity = item.getAttribute("data-quantity");

			var serialNumber = target.dataset.serial;
			newSliderNode = BX.create("div", {
				attrs: {
					className: "set_item",
					"data-id": itemId,
					"data-img": itemImg ? itemImg : "",
					"data-url": itemUrl,
					"data-name": itemName,
					"data-print-price": itemPrintPrice,
					"data-print-old-price": itemPrintOldPrice,
					"data-price": itemPrice,
					"data-old-price": itemOldPrice,
					"data-diff-price": itemDiffPrice,
					"data-measure": itemMeasure,
					"data-quantity": itemBasketQuantity,
					"data-count": itemCount
				},
				children: [
					BX.create("div", {
							attrs: {
								className: "set_image__wrap"
							},
							children: [
								BX.create("a", {
									attrs: {
										title: itemName
									},
									children: [
										BX.create("img", {
											attrs: {
												src: itemImg ? itemImg : this.noFotoSrc,
											}
										})
									]
								}),
								BX.create("span", {
									attrs: {
										className: "number"
									},
									text: itemCount
								})
							]
						}
					),
					BX.create("div", {
							attrs: {
								className: "set_info"
							},
							children: [
								BX.create("label", {
									attrs: {
										for: "check-in"+itemId,
										class: "set_check-in js-active",
										'data-role': "set-add-btn"
									},
									children: [
										BX.create('input',{
											attrs: {
												id: "check-in"+itemId,
												type: "checkbox",
												'data-role': "set-add-btn"
											},
										}),
										BX.create('span',{
											attrs: {
												'data-role': "set-add-btn",
												'data-serial': serialNumber
											},
										}),
									]
								}),
								BX.create("div", {
									attrs: {
										class: 'set_name'
									},
									children:[
										BX.create('a',{
											attrs: {
												href: itemUrl,
												titel: itemName
											},
											children:[
												BX.create('span',{
													attrs:{
														class:"name"
													},
													children: [
														BX.create('span', {
															attrs: {
																class: 'brand_name'
															},
															text: itemName
														})
													]
												}),
												BX.create('span',{
													attrs:{
														class:"price"
													},
													text: itemPrintPrice
												})
											]
										})
									]
								})
							]
						}
					)]
			});

			if (!!this.notAvailProduct)
				this.sliderItemsCont.insertBefore(newSliderNode, this.notAvailProduct);
			else
				this.sliderItemsCont.appendChild(newSliderNode);

			this.numSliderItems++;
			this.numSetItems--;
			this.generateSliderStyles();
			BX.remove(item);


			for (i = 0, l = this.setIds.length; i < l; i++)
			{
				if (this.setIds[i] == itemId)
					this.setIds.splice(i, 1);
			}

			this.recountPrice();

			if (this.numSetItems <= 0)
			{
				//BX.adjust(this.emptySetMessage, { style: { display: 'inline-block' }, html: this.messages.EMPTY_SET });
				BX.remove(itemDel);
			}


			if (this.numSliderItems > 0 && this.sliderParentCont)
			{
				this.sliderParentCont.style.display = '';
			}

		}
	};*/

	/*SetConstructor.prototype.addToSet = function()
	{
		var target = BX.proxy_context,
			item,
			itemId,
			itemName,
			itemUrl,
			itemImg,
			itemPrintPrice,
			itemPrice,
			itemPrintOldPrice,
			itemOldPrice,
			itemDiffPrice,
			itemMeasure,
			itemBasketQuantity,
			newSetNode,
			itemCount;

		if (!!target && target.hasAttribute('data-role') && target.getAttribute('data-role') == 'set-add-btn')
		{
			item = target.parentNode.parentNode.parentNode;
			itemId = item.getAttribute("data-id");
			itemName = item.getAttribute("data-name");
			itemCount = item.getAttribute("data-count");
			itemUrl = item.getAttribute("data-url");
			itemImg = item.getAttribute("data-img");
			itemPrintPrice = item.getAttribute("data-print-price");
			itemPrice = item.getAttribute("data-price");
			itemPrintOldPrice = item.getAttribute("data-print-old-price");
			itemOldPrice = item.getAttribute("data-old-price");
			itemDiffPrice = item.getAttribute("data-diff-price");
			itemMeasure = item.getAttribute("data-measure");
			itemBasketQuantity = item.getAttribute("data-quantity");

			var serialNumber = target.dataset.serial;
			newSliderNode = BX.create("div", {
				attrs: {
					className: "set_item",
					"data-id": itemId,
					"data-img": itemImg ? itemImg : "",
					"data-url": itemUrl,
					"data-name": itemName,
					"data-print-price": itemPrintPrice,
					"data-print-old-price": itemPrintOldPrice,
					"data-price": itemPrice,
					"data-old-price": itemOldPrice,
					"data-diff-price": itemDiffPrice,
					"data-measure": itemMeasure,
					"data-quantity": itemBasketQuantity,
					"data-count": itemCount
				},
				children: [
					BX.create("div", {
							attrs: {
								className: "set_image__wrap"
							},
							children: [
								BX.create("a", {
									attrs: {
										title: itemName
									},
									children: [
										BX.create("img", {
											attrs: {
												src: itemImg ? itemImg : this.noFotoSrc,
											}
										})
									]
								}),
								BX.create("span", {
									attrs: {
										className: "number"
									},
									text: itemCount
								})
							]
						}
					),
					BX.create("div", {
							attrs: {
								className: "set_info"
							},
							children: [
								BX.create("label", {
									attrs: {
										for: "check-in"+itemId,
										class: "set_check-in active js-active",
										'data-role': "set-delete-btn"
									},
									children: [
										BX.create('input',{
											attrs: {
												id: "check-in"+itemId,
												type: "checkbox",
												'data-role': "set-delete-btn"
											},
										}),
										BX.create('span',{
											attrs: {
												'data-role': "set-delete-btn",
												'data-serial': serialNumber
											},
										}),
									]
								}),
								BX.create("div", {
									attrs: {
										class: 'set_name'
									},
									children:[
										BX.create('a',{
											attrs: {
												href: itemUrl,
												titel: itemName
											},
											children:[
												BX.create('span',{
													attrs:{
														class:"name"
													},
													children: [
														BX.create('span', {
															attrs: {
																class: 'brand_name'
															},
															text: itemName
														})
													]
												}),
												BX.create('span',{
													attrs:{
														class:"price"
													},
													text: itemPrintPrice
												})
											]
										})
									]
								})
							]
						}
					)]
			});

			this.setItemsCont.appendChild(newSetNode);

			this.numSliderItems--;
			this.numSetItems++;
			this.generateSliderStyles();
			BX.remove(item);
			this.setIds.push(+itemId);
			this.recountPrice();


			if (this.numSetItems > 0 && !!this.emptySetMessage)
				BX.adjust(this.emptySetMessage, { style: { display: 'none' }, html: '' });

			if (this.numSliderItems <= 0 && this.sliderParentCont)
			{
				this.sliderParentCont.style.display = 'none';
			}

			$('.set_container').append(newSliderNode);
		}

	};*/

	SetConstructor.prototype.recountPrice = function()
	{
		var sumPrice = this.mainElementPrice*this.mainElementBasketQuantity,
			sumOldPrice = this.mainElementOldPrice*this.mainElementBasketQuantity,
			sumDiffDiscountPrice = this.mainElementDiffPrice*this.mainElementBasketQuantity,
			setItems = BX.findChildren(this.setItemsCont, {tagName: "div"}, true),
			i,
			l,
			ratio;

		if (setItems)
		{
			for(i = 0, l = setItems.length; i<l; i++)
			{
				if(setItems[i].getAttribute("data-active") != 'N')
				{
					ratio = Number(setItems[i].getAttribute("data-quantity")) || 1;
					sumPrice += Number(setItems[i].getAttribute("data-price"))*ratio;
					sumOldPrice += Number(setItems[i].getAttribute("data-old-price"))*ratio;
					sumDiffDiscountPrice += Number(setItems[i].getAttribute("data-diff-price"))*ratio;
				}

			}
		}
		this.setPriceCont.innerHTML = BX.Currency.currencyFormat(sumPrice, this.currency, true);
		//this.setPriceDuplicateCont.innerHTML = BX.Currency.currencyFormat(sumPrice, this.currency, true);
		if (Math.floor(sumDiffDiscountPrice*100) > 0)
		{
			this.setOldPriceCont.innerHTML = BX.Currency.currencyFormat(sumOldPrice, this.currency, true);
			/*this.setDiffPriceCont.innerHTML = BX.Currency.currencyFormat(sumDiffDiscountPrice, this.currency, true);
			BX.style(this.setOldPriceRow, 'display', 'block');
			BX.style(this.setDiffPriceRow, 'display', 'block');*/
		}
		else
		{
            this.setOldPriceCont.innerHTML = '';
			/*BX.style(this.setOldPriceRow, 'display', 'none');
			BX.style(this.setDiffPriceRow, 'display', 'none');
			this.setDiffPriceCont.innerHTML = '';*/
		}

	};

	SetConstructor.prototype.addToBasket = function()
	{
		var target = BX.proxy_context;
        $('.set_to-cart[data-role="set-buy-btn"]').hide();
        $('.btn-loader').show();
		//BX.showWait(target.parentNode);

		BX.ajax.post(
			this.ajaxPath,
			{
				sessid: BX.bitrix_sessid(),
				action: 'catalogSetAdd2Basket',
				set_ids: this.setIds,
				lid: this.lid,
				iblockId: this.iblockId,
				setOffersCartProps: this.offersCartProps,
				itemsRatio: this.itemsRatio
			},
			BX.proxy(function(result)
			{
				//BX.closeWait();
                BX.onCustomEvent('OnBasketChange');
                $('.set_to-cart[data-role="set-buy-btn"]').hide();
                $('.btn-loader').hide();
                $('.kit').show();
				//document.location.href = this.basketUrl;
			}, this)
		);
	};

	return SetConstructor;
})();