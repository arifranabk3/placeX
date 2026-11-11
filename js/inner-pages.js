$(function(){
  const $panel=$(".vehicle-filter-panel");
  if(!$panel.length)return;
  const $cards=$(".vehicle-result");
  const val=id=>String($(id).val()||"").trim().toLowerCase();
  const checked=name=>$(`input[name="${name}"]:checked`).map(function(){return this.value.toLowerCase()}).get();
  function runVehicleFilters(){
    const keyword=val("#vehicle-keyword"),city=val("#vehicle-city"),reg=val("#vehicle-registration");
    const make=val("#vehicle-make"),model=val("#vehicle-model");
    const minPrice=Number($("#vehicle-price-min").val())||0,maxPrice=Number($("#vehicle-price-max").val())||Infinity;
    const minYear=Number($("#vehicle-year-min").val())||0,maxYear=Number($("#vehicle-year-max").val())||9999;
    const minKm=Number($("#vehicle-km-min").val())||0,maxKm=Number($("#vehicle-km-max").val())||Infinity;
    const minCc=Number($("#vehicle-cc-min").val())||0,maxCc=Number($("#vehicle-cc-max").val())||Infinity;
    const transmissions=checked("vehicle-transmission"),bodies=checked("vehicle-body"),fuels=checked("vehicle-fuel"),assemblies=checked("vehicle-assembly"),sellers=checked("vehicle-seller"),ads=checked("vehicle-ad");
    let visible=0;
    $cards.each(function(){
      const c=this.dataset,txt=$(this).text().toLowerCase();
      const ok=(!keyword||txt.includes(keyword))&&(!city||c.city.toLowerCase()===city)&&(!reg||c.city.toLowerCase()===reg)&&(!make||c.make.toLowerCase()===make)&&(!model||c.model.toLowerCase()===model)&&Number(c.price)>=minPrice&&Number(c.price)<=maxPrice&&Number(c.year)>=minYear&&Number(c.year)<=maxYear&&Number(c.km)>=minKm&&Number(c.km)<=maxKm&&Number(c.cc)>=minCc&&Number(c.cc)<=maxCc&&(!transmissions.length||transmissions.includes(c.transmission.toLowerCase()))&&(!bodies.length||bodies.includes(c.body.toLowerCase()))&&(!fuels.length||fuels.includes(c.fuel.toLowerCase()))&&(!assemblies.length||assemblies.includes(c.assembly.toLowerCase()))&&(!sellers.length||sellers.includes(c.seller.toLowerCase()))&&(!ads.includes("verified")||c.verified==="true")&&(!ads.includes("featured")||c.featured==="true")&&(!ads.includes("photos")||!!$(this).find(".inner-card-image img").attr("src"));
      $(this).toggle(ok);if(ok)visible++;
    });
    $(".vehicle-result-count").text(`Showing ${visible} of ${$cards.length} sample listings`);
  }
  function reset(){ $panel.find("input").val("").prop("checked",false);$panel.find("select").val("");runVehicleFilters(); }
  $(".vehicle-filter-toggle").on("click",function(){const expanded=$(this).attr("aria-expanded")==="true";$(this).attr("aria-expanded",String(!expanded)).next(".vehicle-filter-content").toggleClass("is-collapsed",expanded);});
  $panel.on("change input","input,select",runVehicleFilters);
  $(".vehicle-apply").on("click",runVehicleFilters);
  $(".vehicle-reset,.vehicle-reset-secondary").on("click",reset);
  $(".vehicle-quick-options button").on("click",function(){$("#vehicle-price-min").val($(this).data("price-min")||"");$("#vehicle-price-max").val($(this).data("price-max")||"");runVehicleFilters();});
  $(".vehicle-sort").on("change",function(){
    const mode=this.value,items=$cards.get();
    items.sort((a,b)=>mode==="price-low"?+a.dataset.price- +b.dataset.price:mode==="price-high"?+b.dataset.price- +a.dataset.price:mode==="year"?+b.dataset.year- +a.dataset.year:0);
    $(".inner-card-grid").append(items);
  });
  runVehicleFilters();
});