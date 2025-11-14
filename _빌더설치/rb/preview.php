<?php
include_once('./_common.php');

$preview_id = isset($_GET['pr_id']) ? htmlspecialchars2($_GET['pr_id']) : '';

if (!$preview_id)
  alert('올바른 경로로 접근해 주세요.');

if (!isset($preview_config)) {
  alert('프리뷰 설정을 불러올 수 없습니다.');
}

$preview_core['title'] = !empty($preview_config['pr_title']) ? $preview_config['pr_title'] : '프리뷰 제목 없음'; // 프리뷰 제목
$preview_core['desc'] = !empty($preview_config['pr_desc']) ? $preview_config['pr_desc'] : '프리뷰 설명 없음';  // 프리뷰 설명
?>
<!doctype html>
<html lang="ko">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title><?php echo $preview_config['pr_title']; ?></title>
  <style>
    /* 기본 여백 제거 & 뷰포트 전체 사용 */
    html,
    body {
      height: 100%;
      margin: 0;
      background: #F2F4F6;
    }

    /* 레이아웃: 위 50px / 아래 나머지 */
    .layout {
      /* 모바일 주소창 변화까지 신경 쓸 땐 100dvh 사용 권장 */
      height: 100vh;
      /* 필요시 100dvh */
      display: grid;
      grid-template-rows: 50px 1fr;
    }

    /* ===== 상단바 스타일 ===== */
    .topbar {
      height: 50px;
      padding: 0 12px;
      box-sizing: border-box;
      display: grid;
      grid-template-columns: auto 1fr auto;
      gap: 12px;
      align-items: center;
      background: #fff;
      border-bottom: 1px solid #e5e7eb;
    }

    /* 왼쪽 텍스트(두 줄) */
    .layout-meta {
      display: flex;
      flex-direction: column;
      justify-content: center;
      min-width: 0;
    }

    .layout-name {
      font-weight: 600;
      font-size: 14px;
      line-height: 1.1;
    }

    .layout-desc {
      margin-top: 2px;
      font-size: 12px;
      line-height: 1.1;
      color: #6b7280;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    /* 가운데 분리선 */
    .topbar-divider {
      height: 0;
      border-top: 1px dashed #e5e7eb;
      width: 100%;
      align-self: center;
    }

    /* 오른쪽 토글(라디오 기반 세그먼트 버튼) */
    .viewport-toggle {
      display: inline-grid;
      grid-auto-flow: column;
      gap: 0;
      border: 1px solid #d1d5db;
      border-radius: 9999px;
      padding: 2px;
    }

    .viewport-toggle input {
      position: absolute;
      opacity: 0;
      pointer-events: none;
    }

    .viewport-toggle label {
      padding: 6px 12px;
      font-size: 12px;
      line-height: 1;
      cursor: pointer;
      user-select: none;
      border-radius: 9999px;
    }

    #vp-pc:checked+label,
    #vp-mobile:checked+label {
      background: #111827;
      color: #fff;
    }

    /* ===== Iframe 스타일 ===== */
    .frame {
      width: 100%;
      height: 100%;
      border: 0;
      display: block;
      /* 여백/라인 제거 안정화 */
      margin: 0 auto;
      transition: width 0.3s ease;
    }

    /* PC / Mobile 상태 클래스에 따른 폭 제어 */
    .layout.is-pc .frame {
      width: 100%;
    }

    .layout.is-mobile .frame {
      width: 480px;
      max-width: 100%;
      border-left: 1px solid #e5e7eb;
      border-right: 1px solid #e5e7eb;
    }

    /* (선택) 상단 폭이 너무 좁을 때 왼쪽 텍스트 폭 제한 */
    @media (max-width: 480px) {
      .layout-meta {
        max-width: 50vw;
      }
    }
  </style>
</head>

<body>
  <div class="layout">
    <div class="topbar">
      <!-- 왼쪽: 레이아웃 이름/설명 (두 줄) -->
      <div class="layout-meta">
        <span class="layout-name"><?php echo $preview_core['title']; ?></span>
        <span class="layout-desc"><?php echo $preview_core['desc']; ?></span>
      </div>

      <!-- 가운데: 분리선 -->
      <div class="topbar-divider" aria-hidden="true"></div>

      <!-- 오른쪽: PC / Mobile 토글 -->
      <fieldset class="viewport-toggle" aria-label="뷰포트 선택">
        <input type="radio" name="viewport" id="vp-pc" value="pc" checked>
        <label for="vp-pc">PC</label>

        <input type="radio" name="viewport" id="vp-mobile" value="mobile">
        <label for="vp-mobile">Mobile</label>
      </fieldset>
    </div>

    <iframe class="frame" src="./rb.preview/preview.php?pr_id=<?php echo $preview_id; ?>" title="컨텐츠 프리뷰"></iframe>
  </div>

</body>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var layout = document.querySelector('.layout');
    var pc = document.getElementById('vp-pc');
    var mobile = document.getElementById('vp-mobile');

    function applyViewport() {
      layout.classList.toggle('is-pc', pc && pc.checked);
      layout.classList.toggle('is-mobile', mobile && mobile.checked);
    }

    if (pc) pc.addEventListener('change', applyViewport);
    if (mobile) mobile.addEventListener('change', applyViewport);

    // 초기 상태 반영
    applyViewport();
  });
</script>
<script>
  /**
   * 아이프레임 내부의 모든 내비게이션에 고정 쿼리 파라미터를 부착
   * - sameOriginOnly: true면 프레임 문서와 같은 오리진으로 가는 경우에만 부착
   * - key/value: 붙일 쿼리 키/값
   */
  function installQueryAppender(frame, { key, value, sameOriginOnly = true }) {
    function addParam(url, base) {
      try {
        const u = new URL(url, base);
        if (sameOriginOnly && u.origin !== base.origin) return u.href;
        if (!u.searchParams.has(key)) u.searchParams.set(key, value);
        return u.href;
      } catch (e) { return url; }
    }

    frame.addEventListener('load', () => {
      let doc, win, base;
      try {
        doc = frame.contentDocument;
        win = frame.contentWindow;
        base = new URL(doc.baseURI);
      } catch (e) {
        // 교차 출처면 접근 불가 → 여기선 할 수 없음
        return;
      }

      // 1) 링크 클릭 가로채기 (target=_blank 포함)
      doc.addEventListener('click', (e) => {
        const a = e.target.closest && e.target.closest('a[href]');
        if (!a) return;

        const newHref = addParam(a.getAttribute('href'), base);
        if (newHref === a.href) return; // 이미 붙어있음

        e.preventDefault();
        e.stopPropagation();

        const target = (a.getAttribute('target') || '').toLowerCase();
        if (target === '_blank') {
          win.open(newHref, '_blank', 'noopener');
        } else if (target && target !== '_self') {
          // 다른 이름의 윈도우/프레임
          win.open(newHref, target);
        } else {
          win.location.assign(newHref);
        }
      }, true); // 캡처 단계에서 선제 차단

      // 2) 폼 제출 가로채기 (GET/POST 모두 action에 쿼리 부착)
      doc.addEventListener('submit', (e) => {
        const form = e.target;
        if (!form || !form.action) return;
        form.action = addParam(form.action, base);
        // GET인 경우: 쿼리에 합쳐져 전송
        // POST인 경우: URL(action) 쿼리로 붙고 바디는 그대로
      }, true);

      // 3) SPA 라우팅(patch pushState/replaceState)에도 부착
      try {
        ['pushState', 'replaceState'].forEach((fn) => {
          const orig = win.history[fn];
          if (typeof orig !== 'function') return;
          win.history[fn] = function (state, title, url) {
            if (typeof url === 'string') url = addParam(url, base);
            return orig.apply(this, [state, title, url]);
          };
        });

        // location.assign 등으로 동일 문서 내에서만 바꾸는 경우를 대비해 popstate 시에도 보정(선택)
        win.addEventListener('popstate', () => {
          try {
            const cur = win.location.href;
            const fixed = addParam(cur, base);
            if (fixed !== cur) win.history.replaceState(win.history.state, document.title, fixed);
          } catch (_) { }
        });
      } catch (_) { }
    });
  }

  // 사용 예시: 고정으로 rb_preview=1 부착, 같은 오리진에만 적용
  document.addEventListener('DOMContentLoaded', () => {
    const frame = document.querySelector('.frame'); // 당신의 iframe 요소
    if (frame) installQueryAppender(frame, {
      key: 'pr_id',
      value: '<?php echo $preview_id; ?>',
      sameOriginOnly: true
    });
  });
</script>

</html>