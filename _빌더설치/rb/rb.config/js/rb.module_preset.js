(function ($) {
  'use strict';

  // 공통 유틸
  var SEL = {
    layoutSelect:        'select[name="preset_selected_layout"]',
    panel:               '.rb_config.rb_config_mod3',
    side:                '.sh-side-options',
    moduleListWrap:      '.rb_config.rb_config_mod3 .select_module .module_list_content',
    moduleSection:       '.rb_config.rb_config_mod3 .rb_config_sec.select_module',
    presetSelect:        'select[name="preset_selected"]',
    presetInfo:          '.rb_config.rb_config_mod3 .preset_info',
    typeInput:           'input[name="preset_md_type"]',
    themeInput:          'input[name="preset_md_theme"]',
    layoutNameInput:     'input[name="preset_md_layout"]'
  };
  var $doc = $(document), $win = $(window);

  function escSel(s){
    return $.escapeSelector ? $.escapeSelector(s) : String(s).replace(/([ !"#$%&'()*+,.\/:;<=>?@[\\\]^`{|}~])/g, '\\$1');
  }
  function cssNum(el, prop){
    var v = window.getComputedStyle(el)[prop];
    return v ? parseFloat(v) || 0 : 0;
  }
  function isSideOpen(){ return $(SEL.side).hasClass('open'); }
  function isPresetVisible(){ return $(SEL.panel).is(':visible') && isSideOpen(); }
  function getLayoutElById(lid){
    return $('.flex_box').filter(function(){
      var v = $.trim(String($(this).attr('data-layout') || ''));
      var t = $.trim(String(lid || ''));
      return v === t || (+v === +t && t !== '');
    }).first();
  }

  // 페이지의 레이아웃 목록 불러오기 (div.flex_box)
  $(function(){
    var $sel = $(SEL.layoutSelect);
    if (!$sel.length) return;
    $sel.find('option:not(:first)').remove();

    var seen = Object.create(null), list = [];
    $('.flex_box[data-layout]').each(function(){
      var v = $.trim($(this).attr('data-layout') || '');
      if (!v || seen[v]) return;
      seen[v] = true; list.push(v);
    });
    $.each(list, function(_, v){ $sel.append($('<option/>', { value: v, text: v })); });
  });

  // 패널이 열릴때 선택된 프리셋 모듈 레이아웃 초기화
  $(function() {
    var $sel = $(SEL.layoutSelect);
    function resetPresetSelect(){ if ($sel.length) $sel.prop('selectedIndex', 0).trigger('change'); }
    $doc.on('click', '.preset_set_btn', function(){ setTimeout(resetPresetSelect, 0); });

    var panel = document.querySelector(SEL.panel);
    if (panel && window.MutationObserver){
      var obs = new MutationObserver(function(){
        if ($(SEL.panel).is(':visible')) resetPresetSelect();
      });
      obs.observe(panel, { attributes:true, attributeFilter:['style','class'] });
    }
  });

  // 패널이 열릴때 main에 padding 추가
  $(function(){
    var $main  = $('main').first();
    var $panel = $(SEL.side).first();
    if (!$main.length || !$panel.length) return;

    var t = $main.css('transition') || '';
    if (t.indexOf('padding-right') === -1){
      $main.css('transition', (t ? t + ', ' : '') + 'padding-right 600ms cubic-bezier(0.86, 0, 0.07, 1)');
    }
    function applyPadding(){ $main.css('padding-right', $panel.hasClass('open') ? '400px' : ''); }
    applyPadding();

    $doc.on('click', '.mobule_set_btn, .setting_set_btn, .preset_set_btn, .sh-side-options-close, .sh-backdrop', function(){
      setTimeout(applyPadding, 0);
    });

    if (window.MutationObserver){
      new MutationObserver(function(muts){
        for (var i=0;i<muts.length;i++){ if (muts[i].attributeName === 'class') applyPadding(); }
      }).observe($panel[0], { attributes:true, attributeFilter:['class'] });
    }
  });

  // 프리셋 모듈 레이아웃 선택시 하이라이트
  $(function(){
    var SELECTOR = SEL.layoutSelect, $overlay = null, $target = null, MARGIN = 10;

    function positionOverlay(){
      if (!$overlay || !$target || !$target.length) return;
      var el = $target[0], off = $target.offset();
      var bt = cssNum(el,'borderTopWidth'), bl = cssNum(el,'borderLeftWidth');
      var pt = cssNum(el,'paddingTop'),    pl = cssNum(el,'paddingLeft');
      var cw = $target.width(), ch = $target.height();
      var top  = off.top + bt + pt - MARGIN;
      var left = off.left + bl + pl - MARGIN;
      var w    = cw + MARGIN*2;
      var h    = ch + MARGIN*2;
      $overlay.css({ top: top, left: left, width: w, height: h });
    }
    function removeOverlay(){ if ($overlay){ $overlay.remove(); $overlay = null; } $target = null; }
    function showOverlay(layoutId){
      var $t = $('.flex_box[data-layout="'+ escSel(layoutId) +'"]').first();
      if (!$t.length){ removeOverlay(); return; }
      $target = $t;
      if (!$overlay){ $overlay = $('<div class="rb-preset-overlay" aria-hidden="true"><div class="badge"></div></div>').appendTo(document.body); }
      $overlay.find('.badge').text('레이아웃 ' + layoutId);
      positionOverlay(); $overlay.show();
    }
    function handleSelect(){
      var v = $(SELECTOR).val();
      if (!v || !isPresetVisible()){ removeOverlay(); return; }
      showOverlay(v);
    }

    $doc.on('change', SELECTOR, handleSelect);
    $win.on('scroll resize', positionOverlay);
    $('main').first().on('transitionend', function(e){
      if (e.originalEvent && e.originalEvent.propertyName === 'padding-right') positionOverlay();
    });

    (function(){
      var panelEl = document.querySelector(SEL.panel);
      if (panelEl && window.MutationObserver){
        new MutationObserver(function(){ if (!isPresetVisible()) removeOverlay(); else positionOverlay(); })
          .observe(panelEl, { attributes:true, attributeFilter:['style','class'] });
      }
    })();

    (function(){
      var sideEl = document.querySelector(SEL.side);
      if (sideEl && window.MutationObserver){
        new MutationObserver(function(muts){
          for (var i=0;i<muts.length;i++){
            if (muts[i].attributeName === 'class'){ if (!isSideOpen()) removeOverlay(); else positionOverlay(); }
          }
        }).observe(sideEl, { attributes:true, attributeFilter:['class'] });
      }
    })();

    $doc.on('click', '.sh-side-options-close, .sh-backdrop', removeOverlay);
    $doc.on('keydown', function(e){ if ((e.key === 'Escape' || e.keyCode === 27) && isPresetVisible()) removeOverlay(); });
  });

  // 레이아웃 선택시 내부 모듈 리스트 가져오기
  $(function(){
    var LSEL = SEL.layoutSelect, LIST_WRAP = SEL.moduleListWrap, MASTER_ID = 'preset_modules_all';

    function h(s){ return String(s == null ? '' : s).replace(/[&<>"']/g, function(m){ return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'})[m]; }); }
    function ensureMaster(){
      var $wrap = $('.rb_config.rb_config_mod3 .select_module').first();
      if (!$wrap.length) return null;
      var $master = $('#'+MASTER_ID);
      if ($master.length) return $master;
      var $anchor = $wrap.find('.module_list_content').first();
      if (!$anchor.length) return null;
      $anchor.before(
        '<div class="preset-all-control">'
        + '<input type="checkbox" id="'+MASTER_ID+'" class="magic-checkbox mod_send" value="1">'
        + '<label for="'+MASTER_ID+'">전체선택/해제</label>'
        + '</div>'
      );
      return $('#'+MASTER_ID);
    }
    function itemBoxes(){ return $(LIST_WRAP + ' input[type="checkbox"][name="preset_selected_modules[]"]'); }
    function updateMaster(){
      var $m = ensureMaster(); if (!$m || !$m.length) return;
      var $items = itemBoxes();
      if (!$items.length){ $m.prop({checked:false, indeterminate:false}); return; }
      var total = $items.length, checked = $items.filter(':checked').length;
      $m.prop('checked', checked === total).prop('indeterminate', checked > 0 && checked < total);
    }
    function buildModuleList(layoutId){
      var $wrap = $(LIST_WRAP).first();
      $wrap.empty();
      var lid = $.trim(layoutId || '');
      if (!lid){ updateMaster(); return; }

      var $layout = getLayoutElById(lid);
      if (!$layout.length){ $wrap.append('<div class="muted">선택한 레이아웃을 찾을 수 없습니다.</div>'); updateMaster(); return; }

      var $mods = $layout.find('.rb_layout_box');
      if (!$mods.length){ $wrap.append('<div class="muted">선택한 레이아웃에 모듈이 없습니다.</div>'); updateMaster(); return; }

      var html = new Array($mods.length);
      $mods.each(function(i, el){
        var $el = $(el);
        var mid = $el.attr('data-id') || $el.attr('data-order-id') || ('idx'+i);
        var title = $el.attr('data-title') || ('모듈 #' + mid);
        var iid = 'preset_module_' + lid + '_' + mid;
        html[i] = '<div>'
        + '<input type="checkbox" class="magic-checkbox mod_send" name="preset_selected_modules[]" id="'+ h(iid) +'" value="'+ h(mid) +'">'
        + '<label for="'+ h(iid) +'">'+ h(title) +'</label>'
        + '</div>';
      });
      $wrap.html(html.join(''));
      ensureMaster(); updateMaster();
    }

    $doc.off('change.presetModules', LSEL).on('change.presetModules', LSEL, function(){
      var v = $.trim($(this).val() || '');
      setTimeout(function(){ buildModuleList(v); }, 0);
    });

    $doc.off('change.presetAllMaster', '#'+MASTER_ID).on('change.presetAllMaster', '#'+MASTER_ID, function(){
      var on = this.checked; itemBoxes().prop('checked', on).trigger('change'); updateMaster();
    });

    $doc.off('change.presetAllItems', LIST_WRAP + ' input[type="checkbox"][name="preset_selected_modules[]"]')
        .on('change.presetAllItems', LIST_WRAP + ' input[type="checkbox"][name="preset_selected_modules[]"]', updateMaster);

    var cur = $.trim($(LSEL).val() || ''); if (cur) buildModuleList(cur);
  });

  // 선택된 레이아웃일 때만 모듈/프리셋 적용 섹션 보이기
  $(function () {
    var LSEL    = 'select[name="preset_selected_layout"]';
    var TARGETS = [
      '.rb_config.rb_config_mod3 .rb_config_sec.select_module',
      '.rb_config.rb_config_mod3 .rb_config_sec.preset_apply'
    ].join(', ');

    function toggleByLayout() {
      var has = $.trim($(LSEL).val() || '') !== '';
      $(TARGETS).toggle(has);
    }

    // 초기 반영
    toggleByLayout();

    // 레이아웃 변경 시 반영
    $(document)
      .off('change.presetSections', LSEL)
      .on('change.presetSections', LSEL, toggleByLayout);

    // 프리셋 패널 버튼으로 열릴 때(선택이 초기화될 수 있으므로) 한 번 동기화
    $(document).on('click.presetSections', '.preset_set_btn', function () {
      setTimeout(toggleByLayout, 0);
    });
  });

  // 모듈 선택시 하이라이트
  $(function(){
    var LSEL = SEL.layoutSelect, LIST_WRAP = SEL.moduleListWrap;
    function findModuleEl(mid){
      var lid = $.trim($(LSEL).val() || ''); if (!lid) return $();
      var $layout = getLayoutElById(lid); if (!$layout.length) return $();
      return $layout.find('.rb_layout_box').filter(function(){
        var a = $.trim(String($(this).attr('data-id')||'')), b = $.trim(String($(this).attr('data-order-id')||'')); return a === mid || b === mid;
      }).first();
    }
    function overlayId(mid){ return 'rbPresetOverlay_mod_' + mid; }
    function positionOverlayFor($ov, el){
      var off = $(el).offset();
      var bt = cssNum(el,'borderTopWidth'), bl = cssNum(el,'borderLeftWidth');
      var pt = cssNum(el,'paddingTop'),    pl = cssNum(el,'paddingLeft');
      var cw = $(el).width(), ch = $(el).height();
      var top  = off.top + bt + pt, left = off.left + bl + pl, w = cw, h = ch;
      $ov.css({ top: top, left: left, width: w, height: h });
    }
    function ensureOverlay(mid, title){
      var id = overlayId(mid), $ov = $('#'+id), $t = findModuleEl(mid);
      if (!$t.length){ $('#'+id).remove(); return; }
      if (!$ov.length){
        $ov = $('<div>', { id:id, 'class':'rb-preset-overlay rb-preset-overlay-mod', 'data-mid':mid, 'aria-hidden':'true' })
              .append('<div class="badge"></div>').appendTo(document.body);
      }
      $ov.find('.badge').text('모듈 ' + (title || mid));
      positionOverlayFor($ov, $t[0]); $ov.show();
    }
    function removeOverlay(mid){ $('#'+overlayId(mid)).remove(); }
    function removeAll(){ $('.rb-preset-overlay-mod').remove(); }
    function repositionAll(){
      $('.rb-preset-overlay-mod').each(function(){
        var mid = $(this).attr('data-mid'), $t  = findModuleEl(mid);
        if ($t.length) positionOverlayFor($(this), $t[0]); else $(this).remove();
      });
    }

    $doc.on('change', LIST_WRAP + ' input[type="checkbox"][name="preset_selected_modules[]"]', function(){
      var mid = $.trim(String($(this).val()||'')), title = $(this).next('label').text();
      if (!mid) return; if (this.checked) ensureOverlay(mid, title); else removeOverlay(mid);
    });

    $doc.on('change', LSEL, function(){ setTimeout(removeAll, 0); });
    $doc.on('click', '.sh-side-options-close, .sh-backdrop', removeAll);
    $doc.on('keydown', function(e){ if ((e.key === 'Escape' || e.keyCode === 27) && $(SEL.panel).is(':visible')) removeAll(); });

    if (window.MutationObserver){
      var pel = document.querySelector(SEL.panel);
      if (pel){
        new MutationObserver(function(){
          var visible = $(SEL.panel).is(':visible') && $(SEL.side).hasClass('open'); if (!visible) removeAll();
        }).observe(pel, { attributes:true, attributeFilter:['style','class'] });
      }
      var sel = document.querySelector(SEL.side);
      if (sel){
        new MutationObserver(function(muts){
          for (var i=0;i<muts.length;i++){
            if (muts[i].attributeName === 'class' && !$(SEL.side).hasClass('open')) removeAll();
          }
        }).observe(sel, { attributes:true, attributeFilter:['class'] });
      }
    }

    $win.on('scroll resize', repositionAll);
    $('main').first().on('transitionend', function(e){
      if (e.originalEvent && e.originalEvent.propertyName === 'padding-right') repositionAll();
    });
  });

  // 모듈 프리셋 내보내기 버튼 생성
  $(function(){
    var WRAP = '.rb_config.rb_config_mod3 .select_module', LIST_WRAP = SEL.moduleListWrap, ACTION_SEL = WRAP + ' .preset_action_wrap', BTN_ID = 'preset_export_btn';
    function itemBoxes(){ return $(LIST_WRAP + ' input[type="checkbox"][name="preset_selected_modules[]"]'); }
    function ensureActions(){
      var $wrap = $(WRAP); if (!$wrap.length) return $();
      var $act = $(ACTION_SEL);
      if (!$act.length){
        $wrap.find('.module_list_content').after(
          '<div class="preset_action_wrap" style="display:none; margin-top:10px;">'
          + '<a id="'+BTN_ID+'" href="javascript:void(0);" class="preset_export_btn"><span>프리셋 내보내기</span></a>'
          + '</div>'
        );
        $act = $(ACTION_SEL);
      }
      return $act;
    }
    function sync(){ var $act = ensureActions(); if ($act.length) $act.toggle(itemBoxes().filter(':checked').length > 0); }

    $doc.on('change.presetExport', LIST_WRAP + ' input[type="checkbox"][name="preset_selected_modules[]"]', sync);
    $doc.on('change.presetExport', SEL.layoutSelect, function(){ setTimeout(function(){ ensureActions(); sync(); }, 0); });

    (function(){
      var el = document.querySelector(LIST_WRAP);
      if (el && ('MutationObserver' in window)){
        new MutationObserver(function(){ ensureActions(); sync(); }).observe(el, { childList:true });
      }
    })();
    ensureActions(); sync();
  });

  // 모듈 프리셋 내보내기 버튼 동작
  $(function(){
    var BTN = '#preset_export_btn', TYPEI = SEL.typeInput, THEMEI = SEL.themeInput;
    function pickPresetName(){
      var n = window.prompt('프리셋 이름을 입력하세요 (영문/숫자만):', ''); if (n == null) return null;
      n = $.trim(n); if (!/^[A-Za-z0-9]+$/.test(n)) { alert('영문/숫자만 입력할 수 있습니다.'); return null; }
      return n;
    }
    function selectedModuleIds(){
      return $(SEL.moduleListWrap + ' input[name="preset_selected_modules[]"]:checked').map(function(){ return $(this).val(); }).get();
    }

    $doc.off('click.presetExportZip', BTN).on('click.presetExportZip', BTN, async function(){
      var ids = selectedModuleIds(); if (!ids.length){ alert('내보내기할 모듈을 선택하세요.'); return; }
      var name = pickPresetName();   if (!name) return;
      var theme = ($(THEMEI).val() || '');
      var ptype = ($(TYPEI).val()  || 'community');

      var fd = new FormData();
      fd.append('preset_name', name);
      ids.forEach(function(id){ fd.append('module_ids[]', id); });
      fd.append('preset_type', ptype);
      fd.append('preset_md_theme', theme);

      try {
        var res = await fetch((window.g5_url || '') + '/rb/rb.config/ajax.preset_export.php', {
          method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest' }, credentials: 'same-origin'
        });
        var ct = (res.headers.get('content-type') || '').toLowerCase();
        if (!res.ok || ct.indexOf('application/json') !== -1) {
          var msg = '내보내기 실패';
          try { var j = await res.json(); if (j && j.message) msg = j.message; } catch(e){}
          alert(msg); return;
        }
        var blob = await res.blob(), a = document.createElement('a');
        a.href = URL.createObjectURL(blob); a.download = 'preset_' + name + '.zip'; document.body.appendChild(a); a.click();
        setTimeout(function(){ URL.revokeObjectURL(a.href); a.remove(); }, 0);
      } catch (err) {
        alert('네트워크 오류로 내보내기에 실패했습니다.');
      }
    });
  });

  // 프리셋 선택 후 프리셋 정보 불러오기
  $(function(){
    var PRESET_SELECT = SEL.presetSelect, PRESET_INFO = SEL.presetInfo;
    function h(s){ return String(s == null ? '' : s).replace(/[&<>"']/g, function(m){ return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[m]); }); }
    function pad2(n){ return (n<10?'0':'')+n; }
    function fmtDate(iso){
      if (!iso) return '-';
      var d = new Date(iso); if (isNaN(d.getTime())) return h(iso);
      return d.getFullYear()+'-'+pad2(d.getMonth()+1)+'-'+pad2(d.getDate())+' '+pad2(d.getHours())+':'+pad2(d.getMinutes());
    }
    function renderInfo(meta, modulesCount, presetDir){
      var rbv = meta && meta.rb_version ? meta.rb_version : '-';
      var cnt = (typeof modulesCount === 'number') ? modulesCount : 0;
      var maked = meta && meta.exported_at ? fmtDate(meta.exported_at) : '-';
      var html = [
        '<div class="preset_meta">',
          '<p><b>리빌더 버전</b> : ', h(rbv), '</p>',
          '<p><b>모듈 개수</b> : ', cnt, '</p>',
          '<p><b>제작일자</b> : ', h(maked), '</p>',
        '</div>',
        presetDir ? (
          '<div class="preset_actions" style="margin-top:10px;">' +
            '<a href="#" id="preset_apply_link" data-preset="'+ h(presetDir) +'" class="preset_apply_btn" role="button">프리셋 적용하기</a>' +
          '</div>'
        ) : ''
      ].join('');
      $(PRESET_INFO).html(html);
    }
    async function loadAndShow(presetDir){
      if (!presetDir){ $(PRESET_INFO).html(''); return; }
      $(PRESET_INFO).html('<p class="muted">불러오는 중…</p>');
      var url = (window.g5_url || '') + '/rb/rb.preset/' + encodeURIComponent(presetDir) + '/preset.json';
      try {
        var res = await fetch(url, { cache: 'no-store', headers: { 'X-Requested-With':'XMLHttpRequest' } });
        if (!res.ok) throw new Error('HTTP '+res.status);
        var data = await res.json();
        var meta = (data && data.meta) || {};
        var modulesCount = Array.isArray(data && data.modules) ? data.modules.length : 0;
        renderInfo(meta, modulesCount, presetDir);
      } catch (e) {
        $(PRESET_INFO).html('<p class="muted">프리셋 정보를 불러오지 못했습니다.</p>');
      }
    }
    $doc.off('change.presetInfo', PRESET_SELECT).on('change.presetInfo', PRESET_SELECT, function(){
      loadAndShow($(this).val());
    });
    $doc.off('click.presetApply', '#preset_apply_link').on('click.presetApply', '#preset_apply_link', function(e){
      e.preventDefault();
      var dir = $(this).data('preset');
      $doc.trigger('rb:preset-apply', { preset: dir });
      alert('프리셋 "'+ dir +'" 적용 준비중입니다. (연동 예정)');
    });

    var initVal = $(PRESET_SELECT).val();
    if (initVal) loadAndShow(initVal); else $(PRESET_INFO).html('');
  });

  // 프리셋 적용하기 버튼 동작
  $(function(){
    var PRESET_SELECT = SEL.presetSelect, LAYOUT_SELECT = SEL.layoutSelect, TYPEI = SEL.typeInput, THEMEI = SEL.themeInput, LAYOUT_NAME_I = SEL.layoutNameInput;

    $doc.off('click.presetApply', '#preset_apply_link').on('click.presetApply', '#preset_apply_link', async function(e){
      e.preventDefault();

      var dir  = $(PRESET_SELECT).val();
      var ptyp = ($(TYPEI).val() || 'community');
      var theme= ($(THEMEI).val() || '');
      var lname= ($(LAYOUT_NAME_I).val() || '');
      var lid  = $(LAYOUT_SELECT).val();

      if (!dir){ alert('프리셋을 선택하세요.'); return; }
      if (!lid){ alert('적용할 레이아웃을 선택하세요.'); return; }

      var $link = $(this), oldTxt = $link.text();
      $link.prop('disabled', true).addClass('disabled').text('적용 중…');

      try {
        var fd = new FormData();
        fd.append('preset_dir', dir);
        fd.append('preset_type', ptyp);
        fd.append('preset_md_theme', theme);
        fd.append('preset_md_layout', lname);
        fd.append('preset_selected_layout', lid);

        var res = await fetch((window.g5_url || '') + '/rb/rb.config/ajax.preset_apply.php', {
          method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest' }, credentials: 'same-origin'
        });
        var data = await res.json().catch(function(){ return null; });
        if (!res.ok || !data || !data.ok){
          alert((data && data.message) ? data.message : '적용에 실패했습니다.');
        } else {
          alert('프리셋 적용 완료! (삽입: ' + (data.inserted||0) + '개)');
          $doc.trigger('rb:preset-applied', { preset: dir, inserted: data.inserted });
        }
      } catch (err) {
        alert('네트워크 오류로 적용에 실패했습니다.');
      } finally {
        $link.prop('disabled', false).removeClass('disabled').text(oldTxt);
      }
    });
  });

  // 프리셋 사이드 패널 열기
  window.toggleSideOptions_open_preset = function(){
    $(SEL.side).addClass('open');
    $('.rb_config').hide();
    $(SEL.panel).show();
    $('.sh-side-options-item').removeClass('active');
    $('.preset_set_btn').addClass('active');
    if (typeof window.rbStopModuleEditMode === 'function') window.rbStopModuleEditMode();
    $('.rb_layout_highlight, .rb_overlay, .rb_highlight_outline').remove();
  };

})(jQuery);
