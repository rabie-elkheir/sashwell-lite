/* Sashwell — motion layer.
   Every effect here is decoration on top of a page that already works.
   Delete this file and nothing breaks. All effects are skipped unless <html> has
   the "motion" class (set in <head> when the OS allows motion and the visitor
   hasn't chosen "Reduce motion" in the footer). See motion.md for the catalogue. */
(function () {
  "use strict";
  var doc = document.documentElement;
  /* Texts for screen readers; a WordPress theme can translate them with window.sashwellI18n */
  var T = window.sashwellI18n || {};
  var MOTION = doc.classList.contains("motion");
  var FINE = matchMedia("(pointer: fine)").matches;
  var easeWipe = function (t) { return t < .5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2; };

  function tween(ms, fn, done) {
    var t0 = performance.now();
    (function step(now) {
      var p = Math.min(1, (now - t0) / ms);
      fn(easeWipe(p));
      if (p < 1) requestAnimationFrame(step); else if (done) done();
    })(t0);
  }
  /* Observes a stand-in (useProxy: the parent) when the element itself is clipped,
     because Chrome reports a fully clip-pathed element as zero-area. */
  function onView(els, cb, threshold, useProxy) {
    if (!("IntersectionObserver" in window)) { els.forEach(cb); return; }
    var map = new Map();
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) return;
        io.unobserve(e.target);
        (map.get(e.target) || [e.target]).forEach(cb);
      });
    }, { threshold: threshold || .35, rootMargin: "0px 0px -8% 0px" });
    els.forEach(function (el) {
      var t = useProxy ? el.parentElement : el;
      if (!map.has(t)) map.set(t, []);
      map.get(t).push(el);
      io.observe(t);
    });
  }

  /* 7. Price counter: works with or without motion (instant when reduced) */
  var kprice = document.getElementById("kprice"), knote = document.getElementById("knote");
  document.querySelectorAll('input[name="kfreq"]').forEach(function (r) {
    r.addEventListener("change", function () {
      var from = parseInt(kprice.textContent.replace(/\D/g, ""), 10), to = parseInt(r.value, 10);
      knote.textContent = r.dataset.note;
      /* keep whatever currency text surrounds the figure ("£26", "26 €") */
      var fmt = function (n) { return kprice.textContent.replace(/\d+/, String(n)); };
      if (!MOTION) { kprice.textContent = fmt(to); return; }
      tween(420, function (p) { kprice.textContent = fmt(Math.round(from + (to - from) * p)); });
    });
  });

  if (!MOTION) return;

  /* 2. Heading wipe reveal */
  /* threshold 0: Chrome counts clip-path, so a fully clipped heading reports ratio 0 */
  /* Split reveal headings into words (text nodes only, so inner spans keep their styling) */
  Array.prototype.forEach.call(document.querySelectorAll(".reveal"), function (h) {
    h.setAttribute("aria-label", h.textContent.replace(/\s+/g, " ").trim());
    var i = 0, walk = document.createTreeWalker(h, NodeFilter.SHOW_TEXT), nodes = [], n;
    while ((n = walk.nextNode())) nodes.push(n);
    nodes.forEach(function (t) {
      var frag = document.createDocumentFragment();
      t.nodeValue.split(/(\s+)/).forEach(function (part) {
        if (!part) return;
        if (/^\s+$/.test(part)) { frag.appendChild(document.createTextNode(part)); return; }
        var w = document.createElement("span"), inner = document.createElement("span");
        w.className = "w"; inner.textContent = part; inner.style.setProperty("--i", i++);
        w.appendChild(inner); frag.appendChild(w);
      });
      t.parentNode.replaceChild(frag, t);
    });
  });
  onView(Array.prototype.slice.call(document.querySelectorAll(".reveal, .bk-day")), function (el) { el.classList.add("in"); }, 0, true);

  /* 3. Live job sheets: ticks and wipes draw in, one line every 90 ms */
  var sheets = Array.prototype.slice.call(document.querySelectorAll(".jobsheet[data-live]"));
  onView(sheets, function (el) { el.classList.add("in"); if (el.hasAttribute("data-loop")) loopSheet(el); }, .3);

  function setDone(li, done) {
    var label = li.querySelector(".label"), sr = li.querySelector(".sr-only");
    li.classList.toggle("done", done); li.classList.toggle("todo", !done);
    label.classList.add("wiped");
    if (sr) sr.textContent = done ? (T.done || "Done: ") : (T.todo || "To do: ");
  }
  function loopSheet(ul) {
    var items = Array.prototype.slice.call(ul.children);
    var initial = items.filter(function (li) { return li.classList.contains("done"); }).length;
    var count = ul.previousElementSibling && ul.previousElementSibling.querySelector(".js-count");
    var paused = false, visible = true, timer;
    var render = function () { if (count) count.textContent = (T.count || "%1$s of %2$s done").replace("%1$s", ul.querySelectorAll(".done").length).replace("%2$s", items.length); };
    ul.addEventListener("pointerenter", function () { paused = true; });
    ul.addEventListener("pointerleave", function () { paused = false; });
    ul.addEventListener("focusin", function () { paused = true; });
    ul.addEventListener("focusout", function () { paused = false; });
    new IntersectionObserver(function (e) { visible = e[0].isIntersecting; }).observe(ul);
    function tick() {
      items.forEach(function (li) { li.style.setProperty("--i", 0); });
      timer = setTimeout(tick, 4200);
      if (paused || !visible || document.hidden) return;
      var next = ul.querySelector("li.todo");
      if (next) {
        next.classList.add("pending"); setDone(next, true);
        var meta = next.querySelector(".meta");
        if (meta) { var d = new Date(); meta.textContent = d.getHours() + ":" + String(d.getMinutes()).padStart(2, "0"); }
        requestAnimationFrame(function () { requestAnimationFrame(function () { next.classList.remove("pending"); }); });
        render();
        if (!ul.querySelector("li.todo")) { clearTimeout(timer); timer = setTimeout(reset, 5200); }
      }
    }
    function reset() {
      items.slice(initial).forEach(function (li) { li.classList.add("pending"); });
      setTimeout(function () {
        items.slice(initial).forEach(function (li) { setDone(li, false); li.classList.remove("pending"); li.querySelector(".label").classList.remove("wiped"); var m = li.querySelector(".meta"); if (m) m.textContent = ""; });
        render(); timer = setTimeout(tick, 2400);
      }, 700);
    }
    timer = setTimeout(tick, 3600);
  }

  /* 1. Fogged glass over the hero photo, wiped clean by the cursor (or a squeegee pass) */
  document.querySelectorAll("[data-fog]").forEach(function (wrap) {
    var fig = wrap.querySelector("figure"), img = fig && fig.querySelector("img");
    if (!img || !window.CanvasRenderingContext2D) return;
    var c = document.createElement("canvas"); c.setAttribute("aria-hidden", "true");
    fig.style.position = "relative"; img.after(c);
    var ctx = c.getContext("2d");
    var tex = document.createElement("canvas"), tctx = tex.getContext("2d");      // the fog itself
    var mask = document.createElement("canvas"), mctx = mask.getContext("2d");   // where it's been wiped
    var W = 0, H = 0, DPR = Math.min(2, window.devicePixelRatio || 1);
    var last = null, lastMove = 0, running = false, visible = true, drips = [], decay = 0;

    function buildTexture() {
      var dark = doc.dataset.theme === "dark";
      tex.width = W; tex.height = H;
      var g = tctx.createLinearGradient(0, 0, 0, H);
      g.addColorStop(0, dark ? "rgba(120,146,172,.34)" : "rgba(226,234,242,.42)");
      g.addColorStop(1, dark ? "rgba(132,158,184,.46)" : "rgba(236,242,247,.58)");
      tctx.clearRect(0, 0, W, H); tctx.fillStyle = g; tctx.fillRect(0, 0, W, H);
      var n = Math.round(W * H / (420 * DPR * DPR)), i, x, y, r;          // condensation beads
      for (i = 0; i < n; i++) {
        x = Math.random() * W; y = Math.random() * H; r = (Math.random() * Math.random() * 3.2 + .4) * DPR;
        tctx.fillStyle = "rgba(255,255,255," + (.18 + Math.random() * .42) + ")";
        tctx.beginPath(); tctx.arc(x, y, r, 0, 6.283); tctx.fill();
        if (r > 2.2 * DPR) { tctx.fillStyle = "rgba(14,42,71,.10)"; tctx.beginPath(); tctx.arc(x + r * .3, y + r * .35, r * .7, 0, 6.283); tctx.fill(); }
      }
    }
    function size() {
      var w = img.clientWidth, h = img.clientHeight;
      if (!w || !h) return;
      c.style.width = w + "px"; c.style.height = h + "px";
      W = c.width = mask.width = Math.round(w * DPR); H = c.height = mask.height = Math.round(h * DPR);
      buildTexture(); draw();
    }
    function draw() {
      ctx.globalCompositeOperation = "source-over";
      ctx.clearRect(0, 0, W, H); ctx.drawImage(tex, 0, 0);
      ctx.globalCompositeOperation = "destination-out"; ctx.drawImage(mask, 0, 0);
    }
    function wipe(x0, y0, x1, y1) {
      var lw = Math.max(46, W / DPR * .13) * DPR;
      mctx.globalCompositeOperation = "source-over";
      mctx.strokeStyle = "#000"; mctx.lineCap = "round"; mctx.lineJoin = "round"; mctx.lineWidth = lw;
      mctx.shadowColor = "#000"; mctx.shadowBlur = 10 * DPR;
      mctx.beginPath(); mctx.moveTo(x0, y0); mctx.lineTo(x1, y1); mctx.stroke();
      mctx.shadowBlur = 0;
      if (Math.random() < .14 && drips.length < 24) drips.push({ x: x1 + (Math.random() - .5) * lw * .8, y: y1 + lw * .42, v: (.35 + Math.random() * .7) * DPR, life: 50 + Math.random() * 120, r: (1.4 + Math.random() * 1.8) * DPR });
      lastMove = performance.now(); decay = 0; start();
    }
    function frame(now) {
      if (!running) return;
      if (now - lastMove > 2200 && decay < 80) {                              // after a pause the fog creeps back,
        mctx.globalCompositeOperation = "destination-out";                   // but leaves faint streaks, like real glass
        mctx.fillStyle = "rgba(0,0,0,.018)"; mctx.fillRect(0, 0, W, H); decay++;
      }
      mctx.globalCompositeOperation = "source-over"; mctx.fillStyle = "#000";
      drips = drips.filter(function (d) {                                      // drips run down the clean band
        d.y += d.v; d.v *= .995; d.life--;
        mctx.beginPath(); mctx.arc(d.x, d.y, d.r, 0, 6.283); mctx.fill();
        return d.life > 0 && d.y < H;
      });
      draw();
      if (decay >= 80 && !drips.length) { running = false; return; }
      requestAnimationFrame(frame);
    }
    function start() { if (!running && visible && !document.hidden) { running = true; requestAnimationFrame(frame); } }
    function pt(e) { var r = c.getBoundingClientRect(); return [(e.clientX - r.left) * DPR, (e.clientY - r.top) * DPR]; }

    fig.addEventListener("pointermove", function (e) {
      var r = c.getBoundingClientRect();
      if (e.clientY > r.bottom) { last = null; return; }
      var p = pt(e);
      if (last) wipe(last[0], last[1], p[0], p[1]); else wipe(p[0], p[1], p[0] + .1, p[1]);
      last = p;
    });
    fig.addEventListener("pointerleave", function () { last = null; });
    fig.addEventListener("pointerdown", function () { last = null; });
    fig.style.touchAction = "pan-y";

    function squeegee(delay) {                                                 // an automatic pass, top-left to right
      setTimeout(function () {
        if (!visible || document.hidden) return;
        var y0 = H * (.38 + Math.random() * .14), y1 = H * (.58 + Math.random() * .12), px = -W * .1, py = y0;
        tween(1150, function (p) {
          var x = -W * .1 + W * 1.2 * p, y = y0 + (y1 - y0) * p + Math.sin(p * 6.283) * H * .02;
          wipe(px, py, x, y); px = x; py = y;
        });
      }, delay);
    }
    var idle = 0;
    function idleLoop() { if (performance.now() - lastMove > 9000) squeegee(0); idle = setTimeout(idleLoop, 11000); }

    new IntersectionObserver(function (e) { visible = e[0].isIntersecting; if (visible) start(); }).observe(c);
    document.addEventListener("visibilitychange", function () { if (!document.hidden) start(); });
    new MutationObserver(function () { buildTexture(); draw(); }).observe(doc, { attributes: true, attributeFilter: ["data-theme"] });
    if ("ResizeObserver" in window) new ResizeObserver(size).observe(img); else window.addEventListener("resize", size);
    var go = function () { size(); squeegee(450); idle = setTimeout(idleLoop, 11000); };
    if (img.complete && img.naturalWidth) go(); else img.addEventListener("load", go, { once: true });
  });


  /* Stagger: children of [data-stagger] rise 16px, 60 ms apart */
  onView(Array.prototype.slice.call(document.querySelectorAll("[data-stagger]")), function (el) {
    Array.prototype.forEach.call(el.children, function (c, i) { if (!c.style.getPropertyValue("--n")) c.style.setProperty("--n", i); });
    el.classList.add("in");
  }, .15);

  /* Stats count up once (the final number is in the HTML, so no-JS shows it) */
  onView(Array.prototype.slice.call(document.querySelectorAll("[data-count]")), function (el) {
    var node = el.firstChild, to = parseInt(el.dataset.count, 10);
    if (!node || node.nodeType !== 3) return;
    tween(1400, function (p) { node.nodeValue = Math.round(to * p).toLocaleString("en-GB"); });
  }, .6);

  /* 6. Before/after: one nudge on first view to show it moves */
  onView(Array.prototype.slice.call(document.querySelectorAll(".ba[data-hint]")), function (ba) {
    var range = ba.querySelector("input[type=range]");
    /* one squeegee pass: start mostly "before", wipe across to show the finished room, settle in the middle */
    range.value = 96; range.dispatchEvent(new Event("input"));
    setTimeout(function () {
      tween(1600, function (p) { range.value = Math.round(96 - 88 * p); range.dispatchEvent(new Event("input")); }, function () {
        setTimeout(function () { tween(700, function (p) { range.value = Math.round(8 + 42 * p); range.dispatchEvent(new Event("input")); }); }, 350);
      });
    }, 250);
  }, .5);

  /* 8. Magnetic primary buttons (fine pointers only, max 6px) */
  if (FINE) document.querySelectorAll(".magnetic").forEach(function (b) {
    b.addEventListener("pointermove", function (e) {
      var r = b.getBoundingClientRect();
      var dx = (e.clientX - r.left - r.width / 2) / (r.width / 2), dy = (e.clientY - r.top - r.height / 2) / (r.height / 2);
      b.style.transform = "translate(" + (dx * 6).toFixed(1) + "px," + (dy * 4).toFixed(1) + "px)";
    });
    b.addEventListener("pointerleave", function () { b.style.transform = ""; });
  });
})();
