/* Sashwell — small, dependency-free behaviours.
   Menu, theme, before/after slider, accordion, form validation, quote estimate. */
(function () {
  "use strict";
  var doc = document.documentElement;

  /* Theme: light by default on every visit, whatever the device's setting. The header button switches to dark
     for the rest of this visit only (sessionStorage), so a new visit always starts light. The inline head script
     applies the same rule before the first paint. */
  var store = {
    get: function (k) { try { return localStorage.getItem(k); } catch (e) { return null; } },
    set: function (k, v) { try { localStorage.setItem(k, v); } catch (e) {} }
  };
  var themeStore = { set: function (v) { try { sessionStorage.setItem("sashwell-theme", v); } catch (e) {} } };
  /* browser chrome follows the theme */
  var tc = document.querySelector('meta[name="theme-color"]');
  var paintChrome = function () { if (tc) tc.setAttribute("content", doc.dataset.theme === "dark" ? "#0b1018" : "#0e2a47"); };
  paintChrome();
  document.querySelectorAll(".theme-toggle").forEach(function (btn) {
    var sync = function () { btn.setAttribute("aria-pressed", doc.dataset.theme === "dark" ? "true" : "false"); };
    sync();
    btn.addEventListener("click", function () {
      var flip = function () {
        doc.dataset.theme = doc.dataset.theme === "dark" ? "light" : "dark";
        themeStore.set(doc.dataset.theme);
        document.querySelectorAll(".theme-toggle").forEach(function (b) { b.setAttribute("aria-pressed", doc.dataset.theme === "dark" ? "true" : "false"); });
        paintChrome();
      };
      /* a soft cross-fade where supported, instant otherwise or with reduced motion */
      if (document.startViewTransition && !matchMedia("(prefers-reduced-motion: reduce)").matches) document.startViewTransition(flip); else flip();
    });
  });

  /* Dialog layers: off-canvas panel and search overlay */
  var lastFocus = null;
  function openLayer(id) {
    var layer = document.getElementById(id);
    if (!layer) return;
    var other = document.querySelector(".layer.open");
    if (other && other !== layer) { other.classList.remove("open"); other.hidden = true; }
    else lastFocus = document.activeElement;
    layer.hidden = false;
    void layer.offsetWidth;            // commit hidden=false before the wipe starts
    layer.classList.add("open");
    document.body.classList.add("locked");
    var first = layer.querySelector(id === "search" ? "input" : "[data-close]:not(.backdrop)");
    if (first) first.focus();
  }
  function closeLayer(layer) {
    if (!layer || layer.hidden) return;
    layer.classList.remove("open");
    document.body.classList.remove("locked");
    var done = function () { layer.hidden = true; };
    if (doc.classList.contains("motion")) setTimeout(done, 480); else done();
    if (lastFocus) lastFocus.focus();
  }
  document.querySelectorAll("[data-open]").forEach(function (b) {
    b.addEventListener("click", function () { openLayer(b.dataset.open); });
  });
  document.querySelectorAll(".layer").forEach(function (layer) {
    layer.addEventListener("click", function (e) { if (e.target.closest("[data-close]")) closeLayer(layer); });
    layer.addEventListener("keydown", function (e) {
      if (e.key === "Escape") { closeLayer(layer); return; }
      if (e.key !== "Tab") return;     // keep focus inside the open panel
      var f = layer.querySelectorAll('a[href], button:not([disabled]), input, summary');
      f = Array.prototype.filter.call(f, function (el) { return el.offsetParent !== null; });
      if (!f.length) return;
      var first = f[0], last = f[f.length - 1];
      if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
      else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
    });
  });
  document.addEventListener("keydown", function (e) {
    if (e.key === "/" && !/INPUT|TEXTAREA|SELECT/.test(document.activeElement.tagName)) { e.preventDefault(); openLayer("search"); }
  });

  /* Site search over a small static index (edit SEARCH to add pages) */
  var SEARCH = [
    ["service-deep-cleaning.html", "Deep cleaning", "Service", "oven fridge limescale skirting extractor one day deep"],
    ["services.html#regular", "Regular home cleaning", "Service", "weekly fortnightly same crew keep-up"],
    ["services.html#moveout", "Moving in or out", "Service", "move end of tenancy deposit letting agent inventory"],
    ["services.html#office", "Office cleaning", "Service", "commercial evening contract invoice office"],
    ["home-2.html", "Offices & studios", "Page", "office studio clinic contract night key log site walk desks"],
    ["services.html#windows", "Windows & facades", "Service", "glass pole squeegee frames sills"],
    ["services.html#upholstery", "Carpets & sofas", "Service", "rug mattress extraction stain"],
    ["services.html", "All services", "Service", "regular deep office builders move windows carpet sofa"],
    ["pricing.html", "Prices & packages", "Help", "price cost hourly fixed add-ons keep-up deep reset move-out"],
    ["booking.html", "Book or get a quote", "Help", "price estimate book date postcode quote"],
    ["legal.html", "Privacy and terms", "Help", "privacy data gdpr terms cancel cancellation deposit refund"],
    ["faq.html#keys", "Keys & access", "Help", "key safe concierge not home"],
    ["faq.html#cancel", "Cancelling or moving a visit", "Help", "cancel reschedule 48 hours fee"],
    ["faq.html#safety", "Products, pets & children", "Help", "eco safe bleach ecolabel pets"],
    ["faq.html#guarantee", "If we miss something", "Help", "guarantee return 24 hours"],
    ["about.html", "About Sashwell", "Company", "story job sheet first visit"],
    ["team.html", "Our crews", "Company", "staff dbs trained cleaners hiring jobs"],
    ["crew-member.html", "Kerry Walsh, crew lead", "Company", "crew lead profile kerry van deep move-out"],
    ["careers.html", "Careers & open roles", "Company", "jobs hiring apply work wage trial day"],
    ["projects.html", "Projects: before & after", "Company", "gallery photos before after case study"],
    ["coming-soon.html", "Coming to Leeds", "Company", "leeds headingley launch new area"],
    ["contact.html", "Contact the office", "Company", "phone email address hours contact"],
    ["blog-single.html", "Moving out? Five places agents check", "Article", "move oven extractor washing machine silicone walls deposit"],
    ["blog.html", "Cleaning advice", "Article", "articles blog tips"]
  ];
  var q = document.getElementById("q"), out = document.getElementById("q-results"), count = document.getElementById("q-count");
  var esc = function (t) { return t.replace(/[&<>"]/g, function (c) { return { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;" }[c]; }); };
  function runSearch() {
    var v = q.value.trim().toLowerCase(), box = q.closest(".panel");
    box.classList.toggle("has-q", !!v);
    var hits = v ? SEARCH.filter(function (r) { return (r[1] + " " + r[3]).toLowerCase().indexOf(v) > -1; }).slice(0, 6) : SEARCH.slice(0, 4);
    out.innerHTML = hits.map(function (r) {
      var t = esc(r[1]);
      if (v) { var i = r[1].toLowerCase().indexOf(v); if (i > -1) t = esc(r[1].slice(0, i)) + "<mark>" + esc(r[1].slice(i, i + v.length)) + "</mark>" + esc(r[1].slice(i + v.length)); }
      return '<li><a href="' + r[0] + '"><span class="s-t">' + t + '</span><span class="s-c">' + r[2] + '</span></a></li>';
    }).join("");
    out.setAttribute("aria-label", v ? "Results" : "Suggested");
    count.textContent = v ? hits.length + " results" : "";
    var empty = box.querySelector(".empty");
    if (!empty) { empty = document.createElement("p"); empty.className = "empty"; out.after(empty); }
    empty.textContent = v && !hits.length ? "Nothing for “" + q.value + "”. Try “oven”, “keys” or “prices”." : "";
  }
  if (q) {
    q.addEventListener("input", runSearch); runSearch();
    document.querySelectorAll(".s-pop [data-q]").forEach(function (b) { b.addEventListener("click", function () { q.value = b.dataset.q; runSearch(); q.focus(); }); });
    q.addEventListener("keydown", function (e) { if (e.key === "Enter") { var a = out.querySelector("a"); if (a) location.href = a.href; } });
  }

  /* Reduce-motion switch in the footer */
  document.querySelectorAll(".motion-toggle").forEach(function (b) {
    var sync = function () {
      var off = !doc.classList.contains("motion");
      b.setAttribute("aria-pressed", String(off));
      b.textContent = off ? "Motion: reduced" : "Reduce motion";
    };
    sync();
    b.addEventListener("click", function () {
      var turningOff = doc.classList.contains("motion");
      store.set("sashwell-motion", turningOff ? "off" : "on");
      location.reload();
    });
  });

  /* Desktop submenus: hover (fine pointers, with a short close delay), click, Enter/Space,
     Escape closes and returns focus, arrow keys move through the items. */
  var subs = Array.prototype.slice.call(document.querySelectorAll(".nav .sub-toggle"));
  var hoverOK = matchMedia("(hover: hover) and (pointer: fine)").matches;
  function setOpen(b, open) {
    b.setAttribute("aria-expanded", String(open));
    b.parentElement.classList.toggle("open", open);
  }
  function closeAll(except) { subs.forEach(function (b) { if (b !== except) setOpen(b, false); }); }
  function items(li) { return Array.prototype.slice.call(li.querySelectorAll(".sub a")); }
  subs.forEach(function (b) {
    var li = b.parentElement, timer;
    b.addEventListener("click", function () {
      var open = b.getAttribute("aria-expanded") !== "true";
      closeAll(b); setOpen(b, open);
    });
    if (hoverOK) {
      li.addEventListener("pointerenter", function () { clearTimeout(timer); closeAll(b); setOpen(b, true); });
      li.addEventListener("pointerleave", function () { timer = setTimeout(function () { setOpen(b, false); }, 120); });
    }
    li.addEventListener("keydown", function (e) {
      var list = items(li), i = list.indexOf(document.activeElement);
      if (e.key === "Escape") { setOpen(b, false); b.focus(); return; }
      if (e.key === "ArrowDown") {
        e.preventDefault();
        if (b.getAttribute("aria-expanded") !== "true") { closeAll(b); setOpen(b, true); }
        (list[i + 1] || list[0]).focus();
      } else if (e.key === "ArrowUp") {
        e.preventDefault();
        if (i <= 0) b.focus(); else list[i - 1].focus();
      } else if (e.key === "Home" && i > -1) { e.preventDefault(); list[0].focus(); }
      else if (e.key === "End" && i > -1) { e.preventDefault(); list[list.length - 1].focus(); }
    });
    li.addEventListener("focusout", function (e) { if (!li.contains(e.relatedTarget)) setOpen(b, false); });
  });
  document.addEventListener("click", function (e) { if (!e.target.closest(".has-sub")) closeAll(); });

  /* Before / after slider: a native range input drives a CSS variable.
     data-valuetext on .ba overrides the spoken value ({n} = percentage clean; the WordPress widget sets it). */
  document.querySelectorAll(".ba").forEach(function (ba) {
    var range = ba.querySelector("input[type=range]");
    if (!range) return;
    var pct = ba.querySelector("[data-pct]"), lines = ba.querySelectorAll(".ba-sheet li");
    var set = function () {
      var clean = 100 - range.value;
      ba.style.setProperty("--pos", range.value + "%");
      range.setAttribute("aria-valuetext", (ba.dataset.valuetext || "{n}% of the photo shows the finished clean").replace("{n}", clean));
      if (pct) pct.textContent = clean;
      lines.forEach(function (li) { li.classList.toggle("done", clean >= +li.dataset.at); });
    };
    range.addEventListener("input", set);
    set();
  });

  /* Accordion */
  document.querySelectorAll(".acc-btn").forEach(function (btn) {
    btn.addEventListener("click", function () {
      var open = btn.getAttribute("aria-expanded") === "true";
      btn.setAttribute("aria-expanded", String(!open));
      document.getElementById(btn.getAttribute("aria-controls")).hidden = open;
    });
  });

  /* Form validation: native constraints, custom messages, error summary */
  function msgFor(input) {
    var v = input.validity;
    var name = input.dataset.name || "This field";
    if (v.valueMissing) return input.dataset.requiredMsg || (input.type === "checkbox" ? "Please tick this box to continue." : name + " is required.");
    if (v.typeMismatch && input.type === "email") return "Enter an email like name@example.com.";
    if (v.patternMismatch) return input.dataset.patternMsg || "Check the format of " + name.toLowerCase() + ".";
    if (v.rangeUnderflow) return input.dataset.minMsg || "Choose a later date.";
    if (v.tooShort) return name + " needs at least " + input.minLength + " characters.";
    return "";
  }
  function showError(input) {
    var err = document.getElementById(input.id + "-error");
    var m = input.checkValidity() ? "" : msgFor(input);
    input.setAttribute("aria-invalid", m ? "true" : "false");
    if (err) err.textContent = m;
    return m;
  }
  document.querySelectorAll("form[data-validate]").forEach(function (form) {
    form.setAttribute("novalidate", "");
    var fields = form.querySelectorAll("input, select, textarea");
    fields.forEach(function (f) {
      if (!f.id) return;
      f.addEventListener("blur", function () { if (f.value || f.getAttribute("aria-invalid") === "true") showError(f); });
      f.addEventListener("change", function () { if (f.getAttribute("aria-invalid") === "true") showError(f); });
    });
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      var summary = form.querySelector(".error-summary");
      var status = form.querySelector(".form-status");
      var errors = [];
      fields.forEach(function (f) { if (f.id) { var m = showError(f); if (m) errors.push({ id: f.id, m: m }); } });
      if (errors.length) {
        if (summary) {
          summary.hidden = false;
          summary.innerHTML = "<p><strong>" + errors.length + (errors.length === 1 ? " thing needs" : " things need") + " fixing:</strong></p><ul>" +
            errors.map(function (x) { return '<li><a href="#' + x.id + '">' + x.m + "</a></li>"; }).join("") + "</ul>";
          summary.focus();
        } else {
          document.getElementById(errors[0].id).focus();
        }
        if (status) status.textContent = "";
        return;
      }
      if (summary) { summary.hidden = true; summary.innerHTML = ""; }
      /* Demo only: replace with your form endpoint (see README). */
      if (form.dataset.redirect) { window.location.href = form.dataset.redirect + "?" + new URLSearchParams(new FormData(form)).toString(); return; }
      if (status) { status.textContent = form.dataset.success || "Thanks. We'll reply within one working hour."; status.focus(); }
      form.reset();
      fields.forEach(function (f) { f.removeAttribute("aria-invalid"); });
      if (form.id === "booking") updateEstimate();
    });
  });

  /* Earliest bookable date = tomorrow */
  var t = new Date(); t.setDate(t.getDate() + 1);
  var iso = t.toISOString().slice(0, 10);
  document.querySelectorAll('input[type="date"][data-min-tomorrow]').forEach(function (d) { d.min = iso; });

  /* Prefill booking form from the hero quick-quote (query string) */
  var booking = document.getElementById("booking");
  if (booking && location.search) {
    new URLSearchParams(location.search).forEach(function (v, k) {
      var el = booking.querySelector('[name="' + k + '"]');
      if (!el) return;
      if (el.type === "radio") { var r = booking.querySelector('[name="' + k + '"][value="' + CSS.escape(v) + '"]'); if (r) r.checked = true; }
      else el.value = v;
    });
  }

  /* Booking estimate (demo pricing — edit the numbers in data-* attributes). Prices come from data-rate / -hours /
     -fixed / -perbed on the service options, data-price on add-ons and data-discount on the frequency radios, or
     from a JSON map in data-prices on a wrapper of the form (WordPress: Contact Form 7 options carry no data-*):
     { services: { key: { rate, fixed, perbed, hours } }, addons: { key: price }, frequency: { key: 0.05 }, bath: 35 }.
     Words come from data-currency, -empty, -none, -hours-format ("{h} h, {crew}"), -crew-small, -crew-large and
     -discount-format ("−{n}%") on .bk-est. */
  var bkHolder = booking && booking.closest("[data-prices]"), bkPrices = {};
  if (bkHolder) { try { bkPrices = JSON.parse(bkHolder.dataset.prices) || {}; } catch (e) {} }
  function updateEstimate() {
    if (!booking) return;
    var out = document.getElementById("est-total");
    if (!out) return;
    var fd = new FormData(booking);
    var svc = booking.querySelector('[name="service"]');
    if (!svc || svc.selectedIndex < 0) return;
    var opt = svc.options[svc.selectedIndex];
    var P = (bkPrices.services || {})[opt.value] || {};
    var num = function (a, b) { var n = parseFloat(a != null && a !== "" ? a : b); return isNaN(n) ? 0 : n; };
    var est = document.querySelector(".bk-est"), w = (est && est.dataset) || {};
    var cur = w.currency != null ? w.currency : "£";
    var beds = parseInt(fd.get("bedrooms") || "2", 10);
    var baths = parseInt(fd.get("bathrooms") || "1", 10);
    var rate = num(opt.dataset.rate, P.rate);
    var hoursBase = num(opt.dataset.hours, P.hours);
    var fixed = num(opt.dataset.fixed, P.fixed);
    var perBed = num(opt.dataset.perbed, P.perbed);
    var bath = num(bkPrices.bath, 35);
    var price, hours;
    if (rate) {
      hours = Math.max(hoursBase, 1.5 + beds * 0.5 + baths * 0.5);
      price = hours * rate;
    } else {
      price = fixed + Math.max(0, beds - 1) * perBed + Math.max(0, baths - 1) * bath;
      hours = hoursBase + Math.max(0, beds - 1) * 1.25;
    }
    var addons = 0;
    booking.querySelectorAll('input[name="addons"]:checked, input[name="addons[]"]:checked, .bk-adds input[type="checkbox"]:checked').forEach(function (a) { addons += num(a.dataset.price, (bkPrices.addons || {})[a.value]); });
    var freq = booking.querySelector('[name="frequency"]:checked');
    var discount = freq && rate ? num(freq.dataset.discount, (bkPrices.frequency || {})[freq.value]) : 0;
    var visit = price * (1 - discount);
    var total = Math.round(visit + addons);
    out.textContent = cur + total;
    booking.querySelectorAll("[data-est-copy]").forEach(function (c) { c.textContent = cur + total; }); /* phone summary beside the send button */
    var set = function (id, t) { var el = document.getElementById(id); if (el) el.textContent = t; };
    var crew = hours > 4 ? w.crewLarge || "2 people" : w.crewSmall || "1–2 people";
    set("est-service", opt.textContent);
    set("est-hours", (w.hoursFormat || "{h} h, {crew}").replace("{h}", Math.round(hours * 2) / 2).replace("{crew}", crew));
    set("est-addons", addons ? cur + addons : w.none || "None");
    set("est-discount", discount ? (w.discountFormat || "−{n}%").replace("{n}", Math.round(discount * 100)) : w.empty || "—");
  }
  if (booking) { booking.addEventListener("change", updateEstimate); updateEstimate(); }


  /* Tabs (WAI-ARIA pattern: arrows move, Home/End jump) */
  document.querySelectorAll('[role="tablist"]').forEach(function (list) {
    var tabs = Array.prototype.slice.call(list.querySelectorAll('[role="tab"]'));
    function select(t) {
      tabs.forEach(function (x) {
        var on = x === t;
        x.setAttribute("aria-selected", String(on)); x.tabIndex = on ? 0 : -1;
        document.getElementById(x.getAttribute("aria-controls")).hidden = !on;
      });
    }
    tabs.forEach(function (t, i) {
      t.addEventListener("click", function () { select(t); });
      t.addEventListener("keydown", function (e) {
        var n = { ArrowRight: i + 1, ArrowLeft: i - 1, Home: 0, End: tabs.length - 1 }[e.key];
        if (n === undefined) return;
        if (doc.dir === "rtl" && /Arrow/.test(e.key)) n = e.key === "ArrowRight" ? i - 1 : i + 1;
        e.preventDefault(); n = (n + tabs.length) % tabs.length; tabs[n].focus(); select(tabs[n]);
      });
    });
  });

  /* Review slider: arrows, reviewer tabs and arrow keys, no autoplay */
  document.querySelectorAll(".slider").forEach(function (sl) {
    var slides = sl.querySelectorAll(".slide"), chips = sl.querySelectorAll(".tq-chip"), cur = 0;
    function go(n) {
      cur = (n + slides.length) % slides.length;
      slides.forEach(function (s, i) { s.hidden = i !== cur; });
      chips.forEach(function (c, i) { c.setAttribute("aria-pressed", String(i === cur)); });
    }
    sl.querySelector(".prev").addEventListener("click", function () { go(cur - 1); });
    sl.querySelector(".next").addEventListener("click", function () { go(cur + 1); });
    chips.forEach(function (c) { c.addEventListener("click", function () { go(+c.dataset.go); }); });
    sl.addEventListener("keydown", function (e) {
      if (e.key === "ArrowLeft") go(cur - 1); if (e.key === "ArrowRight") go(cur + 1);
    });
  });

  /* Before/after project switcher */
  document.querySelectorAll(".projects").forEach(function (list) {
    var wrap = list.closest(".ba3"), ba = wrap.querySelector(".ba");
    /* data-before / data-after hold an image name that sits next to the current image (the HTML pages),
       or a full image URL with an optional data-*-srcset (the WordPress theme, images from the Media Library) */
    var set = function (img, name, srcset, alt) {
      if (alt !== undefined) img.alt = alt;
      if (/[\/.]/.test(name)) { img.src = name; img.srcset = srcset || ""; return; }
      var dir = img.getAttribute("src").replace(/[^\/]*$/, "");
      img.src = dir + name + "-1200.webp";
      img.srcset = dir + name + "-800.webp 800w, " + dir + name + "-1200.webp 1200w";
    };
    list.querySelectorAll(".proj").forEach(function (b) {
      b.addEventListener("click", function () {
        if (b.getAttribute("aria-pressed") === "true") return;
        list.querySelectorAll(".proj").forEach(function (x) { x.setAttribute("aria-pressed", String(x === b)); });
        ba.classList.add("swap");
        setTimeout(function () {
          var after = ba.querySelector('[data-role="after"]');
          set(ba.querySelector('[data-role="before"]'), b.dataset.before, b.dataset.beforeSrcset, b.dataset.beforeAlt);
          set(after, b.dataset.after, b.dataset.afterSrcset, b.dataset.afterAlt);
          ba.querySelector("[data-t0]").textContent = b.dataset.t0;
          ba.querySelector("[data-t1]").textContent = b.dataset.t1;
          b.dataset.lines.split("|").forEach(function (t, i) { var li = ba.querySelectorAll(".ba-sheet li")[i]; if (li) li.textContent = t; });
          wrap.querySelector("[data-ba-title]").textContent = b.dataset.title;
          wrap.querySelector("[data-ba-meta]").textContent = b.dataset.meta;
          var r = ba.querySelector("input"); r.value = 50; r.dispatchEvent(new Event("input"));
          var done = function () { ba.classList.remove("swap"); };
          if (after.decode) after.decode().then(done, done); else after.onload = done;
        }, 300);
      });
    });
  });

  /* Postcode checker. The form's data-* attributes can override the area, the pattern and the messages
     (the WordPress theme fills them from the widget): data-covered="M1,M4,…", data-pattern (first-part regex),
     data-msg-empty, data-msg-yes, data-msg-no, data-msg-bad ({pc} is replaced by the postcode area). */
  var pcIn = document.getElementById("pc-in"), pcOut = document.getElementById("pc-out");
  if (pcIn) pcIn.form.addEventListener("submit", function (e) {
    e.preventDefault(); /* the WordPress widget has no inline onsubmit */
    var d = pcIn.form.dataset, say = function (msg, pc) { return msg.replace(/\{pc\}/g, pc || ""); };
    var v = pcIn.value.trim().toUpperCase().replace(/\s+/g, " ");
    var m = v.match(new RegExp(d.pattern || "^(M\\d{1,2}[A-Z]?|SK\\d{1,2})\\b"));
    var near = {};
    (d.covered || "M1,M4,M14,M15,M16,M19,M20,M21,M25,M32,M33,M50,SK4").split(",").forEach(function (c) { if (c.trim()) near[c.trim().toUpperCase()] = 1; });
    pcOut.className = "pc-out";
    document.querySelectorAll(".route li").forEach(function (li) { var on = !!m && li.dataset.pc === m[1]; li.classList.toggle("hit", on); if (on && li.parentNode.scrollWidth > li.parentNode.clientWidth) li.parentNode.scrollTo({ left: li.offsetLeft - li.parentNode.offsetLeft - 20, behavior: "smooth" }); });
    if (!v) { var box = pcIn.parentNode; pcOut.textContent = d.msgEmpty || "Start with the first part, e.g. M20."; pcOut.classList.add("hint"); box.classList.remove("nudge"); void box.offsetWidth; box.classList.add("nudge"); pcIn.focus(); return; }
    if (m && near[m[1]]) { pcOut.textContent = say(d.msgYes || "Yes, {pc} is on our regular route.", m[1]); pcOut.classList.add("ok"); }
    else if (m) { pcOut.textContent = say(d.msgNo || "{pc} is outside our usual route. Call 0161 496 0732; we often still say yes.", m[1]); pcOut.classList.add("no"); }
    else { pcOut.textContent = d.msgBad || "That doesn't look like an M or SK postcode."; pcOut.classList.add("no"); }
  });


  /* Office rates (Home 2): desks and nights to a monthly figure. Rates and words come from data-* on [data-calc]
     (data-rate, -desk-hours, -max-shift, -currency, -locale, -hour, -min, -person, -people); the values below are
     the fallbacks. An add-on with data-per="desk" (or the name "supplies") is charged per desk. */
  var calc = document.querySelector("[data-calc]");
  if (calc) (function () {
    var cd = calc.dataset, RATE = +cd.rate || 27, PH_PER_DESK = +cd.deskHours || .15, MAX_SHIFT = +cd.maxShift || 2.5;
    var CUR = cd.currency || "£", LOC = cd.locale || "en-GB", H = cd.hour || " h", MIN = cd.min || " min", ONE = cd.person || " person", MANY = cd.people || " people";
    var desks = calc.querySelector("#c-desks"), out = calc.querySelector("#c-desks-o"), total = calc.querySelector("#c-total"), big = total.parentNode;
    var gbp = function (n) { return CUR + Math.round(n).toLocaleString(LOC); };
    var hrs = function (h) { var m = Math.round(h * 60); return Math.floor(m / 60) + H + (m % 60 ? " " + (m % 60) + MIN : ""); };
    var run = function () {
      var d = +desks.value, n = +calc.querySelector('[name="nights"]:checked').value;
      var ph = Math.max(1.5, Math.round(d * PH_PER_DESK * 2) / 2), crew = Math.ceil(ph / MAX_SHIFT), shifts = n * 52 / 12;
      var extra = 0;
      calc.querySelectorAll('input[type="checkbox"]:checked').forEach(function (c) { extra += (c.dataset.per === "desk" || c.name === "supplies" ? d : 1) * +c.value; });
      out.textContent = d; desks.style.setProperty("--p", ((d - desks.min) / (desks.max - desks.min) * 100).toFixed(1) + "%");
      calc.querySelector("#c-crew").textContent = hrs(ph / crew) + " × " + crew + (crew > 1 ? MANY : ONE);
      calc.querySelector("#c-shifts").textContent = shifts.toFixed(1);
      calc.querySelector("#c-extra").textContent = gbp(extra);
      total.textContent = gbp(ph * RATE * shifts + extra);
      big.classList.remove("tick"); void big.offsetWidth; big.classList.add("tick");
    };
    calc.addEventListener("input", run); calc.addEventListener("change", run); run();
    var cf = calc.querySelector("form"); if (cf) cf.addEventListener("submit", function (e) { e.preventDefault(); });
  })();

  /* Home 3 (one page): section index, slot board, price table and booking summary */
  var opNav = document.querySelector(".op-nav");
  if (opNav) (function () {
    var bar = opNav.querySelector(".op-in"), list = opNav.querySelector(".op-list");
    if (!bar || !list) return; /* the section index needs its list (WordPress: the page-index widget) */
    var links = Array.prototype.slice.call(list.querySelectorAll("a"));
    var secs = links.map(function (a) { var h = a.getAttribute("href"); return h.charAt(0) === "#" ? document.getElementById(h.slice(1)) : null; });
    var cur = -1, ticking = false;
    var spy = function () {
      ticking = false;
      var y = scrollY + 180, i = -1;
      secs.forEach(function (s, k) { if (s && s.offsetTop <= y) i = k; });
      if (innerHeight + scrollY >= document.documentElement.scrollHeight - 4 && i > -1) i = secs.length - 1;
      var start = (secs[0] ? secs[0].offsetTop : 0) - 180, end = document.documentElement.scrollHeight - innerHeight;
      bar.style.setProperty("--p", Math.min(1, Math.max(0, (scrollY - start) / Math.max(1, end - start))).toFixed(3));
      if (i === cur) return;
      cur = i;
      links.forEach(function (a, k) { if (k === i) a.setAttribute("aria-current", "location"); else a.removeAttribute("aria-current"); });
      var a = links[i];
      if (!a && list.scrollLeft) list.scrollTo({ left: 0 });
      if (a && list.scrollWidth > list.clientWidth) list.scrollTo({ left: a.offsetLeft - list.offsetLeft - (list.clientWidth - a.offsetWidth) / 2, behavior: doc.classList.contains("motion") ? "smooth" : "auto" });
    };
    addEventListener("scroll", function () { if (!ticking) { ticking = true; requestAnimationFrame(spy); } }, { passive: true });
    addEventListener("resize", spy); spy();
  })();

  /* Home 3: price table by home size, slot board and booking summary. The price table works on its own; the rest
     needs the booking form #h3-book. Words come from data-sizes (.h3-size), data-note ([data-size-note]), data-empty
     (.h3-sum), data-suffix (price row) and data-from (any [data-svc] element); the strings below are the fallbacks. */
  (function () {
    var form = document.getElementById("h3-book");
    var fSvc = form && form.querySelector("#bf-svc"), fSlot = form && form.querySelector("#bf-slot"), fSize = form && form.querySelector("#bf-size");
    var slots = Array.prototype.slice.call(document.querySelectorAll(".h3-slot")), pick = document.querySelector("[data-pick]");
    var rows = Array.prototype.slice.call(document.querySelectorAll(".h3-pt tbody tr")), note = document.querySelector("[data-size-note]");
    var OTHER = { upholstery: "£35 a room", windows: "£60" };
    var sizeBox = document.querySelector(".h3-size"), sumBox = document.querySelector(".h3-sum");
    var BEDS = sizeBox && sizeBox.dataset.sizes ? sizeBox.dataset.sizes.split("|") : ["1 bedroom", "2 bedrooms", "3 bedrooms", "4 or more bedrooms"];
    var EMPTY = (sumBox && sumBox.dataset.empty) || "Not chosen yet";
    var beds = function (i) { return BEDS[i] || BEDS[BEDS.length - 1]; };
    var money = function (el, n) { return /\d/.test(el.textContent) ? el.textContent.replace(/\d[\d.,]*/, n) : "£" + n; };
    if (!form && !rows.length) return;
    var set = function (sel, v) { if (sel.value !== v) { sel.value = v; sel.dispatchEvent(new Event("change", { bubbles: true })); } };
    var summary = function () {
      var size = +fSize.value, k = fSvc.value, row = k && document.querySelector('.h3-pt a[data-svc="' + k + '"]');
      var price = "–";
      var from = k && document.querySelector('[data-svc="' + k + '"][data-from]');
      if (row) { row = row.closest("tr"); price = money(row.querySelector("[data-price]"), row.dataset.p.split("|")[size]) + (row.hasAttribute("data-suffix") ? row.dataset.suffix : (k === "regular" ? " a visit" : "")); }
      else if (from) price = from.dataset.from;
      else if (OTHER[k]) price = "from " + OTHER[k];
      var put = function (key, txt, empty) { var dd = (form.closest(".oh-walk") || document).querySelector('[data-sum="' + key + '"]'); if (!dd) return; dd.textContent = txt; dd.classList.toggle("is-empty", !!empty); };
      put("service", k ? fSvc.options[fSvc.selectedIndex].text : EMPTY, !k);
      put("slot", fSlot.value ? fSlot.options[fSlot.selectedIndex].text : EMPTY, !fSlot.value);
      put("size", beds(size));
      put("price", price, price === "–");
      slots.forEach(function (b) { b.setAttribute("aria-pressed", String(b.dataset.slot === fSlot.value)); });
      if (pick) {
        /* Texts come from data-msg-idle / data-msg-picked ("{slot} picked.") on .h3-pick; built as nodes, not HTML */
        var pd = (pick.closest(".h3-pick") || pick).dataset, pv = fSlot.value && fSlot.value !== "call", pm = (pd.msgPicked || "{slot} picked.").split("{slot}");
        pick.textContent = pv ? "" : (pd.msgIdle || "Pick a time to hold it.");
        if (pv) { var pb = document.createElement("b"); pb.textContent = fSlot.value; pick.append(pm[0], pb, pm.slice(1).join("{slot}")); }
      }
    };
    var sizeTo = function (i, from) {
      rows.forEach(function (tr) {
        var b = tr.querySelector("[data-price]"); b.textContent = money(b, tr.dataset.p.split("|")[i]);
        tr.querySelector("[data-hrs]").textContent = tr.dataset.h.split("|")[i];
        b.classList.remove("tick"); void b.offsetWidth; b.classList.add("tick");
      });
      if (note) note.textContent = (note.dataset.note || "Prices for a home with {size}.").replace("{size}", beds(i));
      var r = document.querySelector('input[name="h3size"][value="' + i + '"]'); if (r) r.checked = true;
      if (from !== "form" && fSize) set(fSize, String(i));
    };
    document.querySelectorAll('input[name="h3size"]').forEach(function (r) { r.addEventListener("change", function () { sizeTo(+r.value); }); });
    if (!form) return;
    slots.forEach(function (b) { b.addEventListener("click", function () { set(fSlot, b.getAttribute("aria-pressed") === "true" ? "" : b.dataset.slot); summary(); }); });
    document.querySelectorAll("a[data-svc]").forEach(function (a) { a.addEventListener("click", function () { set(fSvc, a.dataset.svc); }); });
    fSize.addEventListener("change", function () { sizeTo(+fSize.value, "form"); });
    form.addEventListener("change", summary);
    form.addEventListener("reset", function () { setTimeout(function () { sizeTo(+fSize.value, "form"); summary(); }); });
    summary();
  })();

  /* Footer year */
  document.querySelectorAll("[data-year]").forEach(function (y) { y.textContent = new Date().getFullYear(); });
})();

/* Selected jobs: hover, focus or press a column label to open its job */
document.querySelectorAll('.cases-stage').forEach(stage => {
  const cols = [...stage.querySelectorAll('.case')];
  const on = c => { if (c.classList.contains('is-on')) return; cols.forEach(x => { x.classList.toggle('is-on', x === c); x.querySelector('.case-label').setAttribute('aria-expanded', x === c); }); stage.dataset.a = c.dataset.i; };
  cols.forEach(c => {
    let t; c.addEventListener('pointerenter', e => { if (e.pointerType === 'mouse') t = setTimeout(() => on(c), 60); });
    c.addEventListener('pointerleave', () => clearTimeout(t));
    c.querySelector('.case-label').addEventListener('click', () => on(c));
  });
});

/* Proof board: the moving list of sign-offs has a pause button (WCAG 2.2.2) and stops when off screen */
document.querySelectorAll('.pf--sheets').forEach(tile => {
  const feed = tile.querySelector('.pf-feed'), btn = tile.querySelector('.pf-pause');
  let user = false, seen = true;
  const set = () => feed.classList.toggle('paused', user || !seen);
  btn.addEventListener('click', () => { user = !user; btn.setAttribute('aria-pressed', user); btn.setAttribute('aria-label', (user ? 'Play' : 'Pause') + ' the list of sign-offs'); set(); });
  if ('IntersectionObserver' in window) new IntersectionObserver(e => { seen = e[0].isIntersecting; set(); }).observe(tile);
});

/* Promises: a soft light follows the pointer across each card */
document.querySelectorAll('.pr-flip').forEach(f => f.closest('.pr').addEventListener('click', e => { if (e.pointerType !== 'mouse') e.currentTarget.classList.toggle('flip'); }));
document.querySelectorAll('.pr').forEach(card => card.addEventListener('pointermove', e => {
  const r = card.getBoundingClientRect();
  card.style.setProperty('--mx', (e.clientX - r.left) + 'px'); card.style.setProperty('--my', (e.clientY - r.top) + 'px');
}));

/* Crews: point at or press a name to bring up their photo and house rule */
document.querySelectorAll('.crew').forEach(box => {
  const rows = [...box.querySelectorAll('.crew-row')], phs = [...box.querySelectorAll('.crew-ph')];
  const on = r => { rows.forEach(x => x.setAttribute('aria-pressed', x === r)); phs.forEach(p => p.classList.toggle('is-on', p.dataset.i === r.dataset.i)); };
  rows.forEach(r => { let t; r.addEventListener('click', () => on(r)); r.addEventListener('pointerenter', e => { if (e.pointerType === 'mouse') t = setTimeout(() => on(r), 60); }); r.addEventListener('pointerleave', () => clearTimeout(t)); });
});

/* Quick contact dock: both buttons always visible once the hero is passed; on wide screens it steps aside while the footer (same contacts) is on screen */
(function () {
  var dock = document.querySelector('.dock'); if (!dock) return;
  var past = false, foot = false, wide = matchMedia('(min-width: 80em)');
  var set = function () { dock.classList.toggle('on', past && !(foot && wide.matches)); };
  var onScroll = function () { past = scrollY > Math.min(innerHeight * .6, 520); set(); };
  addEventListener('scroll', onScroll, { passive: true }); onScroll();
  var f = document.querySelector('.footer');
  if (f && 'IntersectionObserver' in window) new IntersectionObserver(function (e) { foot = e[0].isIntersecting; set(); }).observe(f);
  wide.addEventListener && wide.addEventListener('change', set);
})();

/* Non-critical extras (mobile rails, footer accordion, live office status) load after the page.
   extras.js is loaded from the same folder as this file, with the same query string (cache version),
   so it also works when the pages are served by WordPress. */
(function () {
  var me = document.currentScript && document.currentScript.src;
  var m = me && me.match(/^(.*\/)main\.js(\?.*)?$/);
  var src = m ? m[1] + "extras.js" + (m[2] || "") : "assets/js/extras.js";
  window.addEventListener("load", function () { var s = document.createElement("script"); s.src = src; document.body.appendChild(s); });
})();
