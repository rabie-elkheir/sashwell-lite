/* Sashwell extras: loaded after window load by main.js */
/* Mobile (< 48em): footer link groups fold into an accordion; card lists become swipe rails with a position meter */
(function () {
  /* Texts for screen readers; a WordPress theme can translate them with window.sashwellI18n */
  var T = window.sashwellI18n || {};
  var mq = window.matchMedia("(max-width: 47.99em)");
  /* footer accordion: headings become buttons only on small screens; without JS everything stays open */
  var groups = [].slice.call(document.querySelectorAll(".footer-grid > div > h2")).filter(function (h) { return h.nextElementSibling && h.nextElementSibling.tagName === "UL"; });
  groups.forEach(function (h, i) {
    var ul = h.nextElementSibling, label = h.textContent;
    ul.id = ul.id || "ft-acc-" + i;
    h.dataset.label = label;
  });
  function footer() {
    groups.forEach(function (h) {
      var ul = h.nextElementSibling;
      if (mq.matches && !h.querySelector(".ft-acc-b")) {
        h.innerHTML = '<button class="ft-acc-b" type="button" aria-expanded="false" aria-controls="' + ul.id + '">' + h.dataset.label + "</button>";
        ul.classList.add("ft-acc-p"); ul.hidden = true;
        h.firstChild.addEventListener("click", function () { var o = this.getAttribute("aria-expanded") === "true"; this.setAttribute("aria-expanded", String(!o)); ul.hidden = o; });
      } else if (!mq.matches && h.querySelector(".ft-acc-b")) {
        h.textContent = h.dataset.label; ul.hidden = false; ul.classList.remove("ft-acc-p");
      }
    });
  }
  /* rails */
  var rails = [].slice.call(document.querySelectorAll(".proof, .promises, .bmag, .cases-stage, .pricing3, [data-rail]"));
  var strips = [].slice.call(document.querySelectorAll(".route"));
  rails.forEach(function (r) {
    var items = r.children, n = items.length, m = document.createElement("div");
    m.className = "rail-meter"; m.setAttribute("aria-hidden", "true");
    m.innerHTML = "<span><b>01</b> / " + (n < 10 ? "0" : "") + n + "</span><i></i>";
    r.after(m);
    var b = m.querySelector("b"), bar = m.querySelector("i"), raf = 0;
    bar.style.setProperty("--w", 100 / n + "%");
    function upd() {
      raf = 0;
      var max = r.scrollWidth - r.clientWidth, k = max > 0 ? Math.round(r.scrollLeft / max * (n - 1)) : 0;
      b.textContent = (k < 9 ? "0" : "") + (k + 1);
      bar.style.setProperty("--x", k * 100 + "%");
    }
    r.addEventListener("scroll", function () { if (!raf) raf = requestAnimationFrame(upd); }, { passive: true });
    upd();
  });
  function focusable() {
    rails.concat(strips).forEach(function (r) {
      if (mq.matches && r.scrollWidth > r.clientWidth) {
        var h = r.closest("section"), l = h && h.querySelector("h2");
        r.setAttribute("tabindex", "0");
        if (r.tagName === "DIV") { r.setAttribute("role", "region"); r.setAttribute("aria-label", (T.rail || "%s, swipe for more").replace("%s", l ? l.textContent : (T.cards || "Cards"))); }
      } else if (r.getAttribute("tabindex") === "0") { r.removeAttribute("tabindex"); if (r.tagName === "DIV") { r.removeAttribute("role"); r.removeAttribute("aria-label"); } }
    });
  }
  function apply() { footer(); focusable(); }
  apply();
  (mq.addEventListener ? mq.addEventListener("change", apply) : mq.addListener(apply));
})();

/* Off-canvas: say whether the phone lines are open right now (Mon–Sat 7:30–19:00, UK time) */
(function () {
  var el = document.querySelector("[data-oc-status]"); if (!el) return;
  try {
    var parts = new Intl.DateTimeFormat("en-GB", { timeZone: "Europe/London", weekday: "short", hour: "2-digit", minute: "2-digit", hour12: false }).formatToParts(new Date());
    var get = function (t) { return (parts.filter(function (p) { return p.type === t; })[0] || {}).value; };
    var d = get("weekday"), m = +get("hour") * 60 + +get("minute"), open = d !== "Sun" && m >= 450 && m < 1140;
    el.classList.toggle("is-open", open);
    el.querySelector("span").textContent = open ? "Open now · lines close at 19:00" : (d === "Sat" && m >= 1140) || d === "Sun" ? "Closed · back Monday at 7:30" : m >= 1140 ? "Closed · back tomorrow at 7:30" : "Closed · opens at 7:30";
  } catch (e) {}
})();

/* Blog: topic filter + search, reading progress, contents highlight, copy link, print, comment reply */
(function () {
  var motion = document.documentElement.classList.contains("motion");
  /* filter: buttons in [data-bfilter=x] and an optional [data-bsearch=x] narrow the items of [data-bposts=x] */
  [].forEach.call(document.querySelectorAll("[data-bposts]"), function (list) {
    var k = list.getAttribute("data-bposts"), items = [].slice.call(list.children);
    var bar = document.querySelector('[data-bfilter="' + k + '"]'), q = document.querySelector('[data-bsearch="' + k + '"]');
    var count = document.querySelector('[data-bcount="' + k + '"]'), none = document.querySelector('[data-bempty="' + k + '"]');
    var topic = "all", t;
    function norm(x) { return (x || "").toLowerCase().normalize("NFD").replace(/[̀-ͯ]/g, ""); }
    function run(announce) {
      var words = norm(q && q.value).trim().split(/\s+/).filter(Boolean), n = 0;
      items.forEach(function (it) {
        var txt = norm(it.textContent), ok = (topic === "all" || it.getAttribute("data-topic") === topic) && words.every(function (w) { return txt.indexOf(w) > -1; });
        var was = !it.hidden; it.hidden = !ok; if (ok) n++;
        it.classList.remove("is-in"); if (ok && motion && announce) { void it.offsetWidth; it.classList.add("is-in"); }
      });
      if (none) none.hidden = n > 0;
      if (count && announce) count.textContent = n + (n === 1 ? " article" : " articles") + (topic !== "all" || (q && q.value) ? " match" : "");
    }
    if (bar) bar.addEventListener("click", function (e) {
      var b = e.target.closest("button[data-topic]"); if (!b) return;
      topic = b.getAttribute("data-topic");
      [].forEach.call(bar.querySelectorAll("button[data-topic]"), function (x) { x.setAttribute("aria-pressed", x === b ? "true" : "false"); });
      run(true);
    });
    if (q) q.addEventListener("input", function () { clearTimeout(t); t = setTimeout(function () { run(true); }, 120); });
    [].forEach.call(document.querySelectorAll('[data-bclear="' + k + '"]'), function (c) {
      c.addEventListener("click", function () { if (q) q.value = ""; var all = bar && bar.querySelector('[data-topic="all"]'); if (all) all.click(); else run(true); (q || all || list).focus(); });
    });
    list.classList.add("in");
  });
  /* reading progress: a 3px line across the top, from the start of the article to the end of its text */
  var bar = document.querySelector("[data-progress]"), art = document.querySelector(".aprose");
  if (bar && art) {
    var raf = 0;
    var upd = function () { raf = 0; var r = art.getBoundingClientRect(), h = r.height - innerHeight * .6; bar.style.setProperty("--p", Math.max(0, Math.min(1, (innerHeight * .25 - r.top) / Math.max(h, 1))).toFixed(3)); };
    addEventListener("scroll", function () { if (!raf) raf = requestAnimationFrame(upd); }, { passive: true }); upd();
  }
  /* contents: the heading you're reading is marked in the list */
  var toc = document.querySelector(".atoc");
  if (toc && "IntersectionObserver" in window) {
    var links = [].slice.call(toc.querySelectorAll("a")), heads = links.map(function (a) { return document.getElementById(a.hash.slice(1)); }).filter(Boolean);
    var set = function (id) { links.forEach(function (a) { if (a.hash === "#" + id) a.setAttribute("aria-current", "true"); else a.removeAttribute("aria-current"); }); };
    var io = new IntersectionObserver(function () {
      var cur = heads[0]; heads.forEach(function (h) { if (h.getBoundingClientRect().top < innerHeight * .35) cur = h; }); set(cur.id);
    }, { rootMargin: "0px 0px -60% 0px", threshold: [0, 1] });
    heads.forEach(function (h) { io.observe(h); });
    addEventListener("scroll", function () { var cur = heads[0]; heads.forEach(function (h) { if (h.getBoundingClientRect().top < innerHeight * .35) cur = h; }); set(cur.id); }, { passive: true });
  }
  /* copy link and print */
  var st = document.querySelector("[data-copy-status]");
  [].forEach.call(document.querySelectorAll("[data-copy]"), function (b) {
    var label = b.getAttribute("aria-label");
    b.addEventListener("click", function () {
      var done = function () { b.classList.add("is-done"); b.setAttribute("aria-label", "Link copied"); if (st) st.textContent = "Link copied to the clipboard."; setTimeout(function () { b.classList.remove("is-done"); b.setAttribute("aria-label", label); }, 2200); };
      if (navigator.clipboard) navigator.clipboard.writeText(location.href).then(done, done); else done();
    });
  });
  [].forEach.call(document.querySelectorAll("[data-print]"), function (b) { b.addEventListener("click", function () { print(); }); });
  /* reply: the form says who you're answering; Cancel clears it */
  var to = document.querySelector("[data-reply-to]"), msg = document.getElementById("cm-msg");
  [].forEach.call(document.querySelectorAll("[data-reply]"), function (b) {
    b.addEventListener("click", function () {
      if (!to || !msg) return;
      to.hidden = false; to.querySelector("span").textContent = "Replying to " + b.getAttribute("data-reply");
      msg.scrollIntoView({ block: "center", behavior: motion ? "smooth" : "auto" }); msg.focus({ preventScroll: true });
    });
  });
  var cancel = document.querySelector("[data-reply-cancel]");
  if (cancel) cancel.addEventListener("click", function () { to.hidden = true; if (msg) msg.focus(); });
})();
