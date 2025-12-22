@extends('layouts.app')

@section('title', 'Try it — ITLAB')
@section('body-class', 'page-try-it')

@section('content')
@push('styles')
<style>
    body {
      margin: 0;
      font-family: "Poppins", system-ui, sans-serif;
      background: #020617;
      color: #e5e7eb;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .tiy-navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 12px 24px;
      background: #020617;
      border-bottom: 1px solid #111827;
    }

    .tiy-navbar .logo {
      font-weight: 700;
      letter-spacing: 0.08em;
    }

    .tiy-navbar .logo span {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 28px;
      height: 28px;
      margin-right: 6px;
      border-radius: 10px;
      background: #22c55e;
      color: #022c22;
      font-size: 14px;
    }

    .tiy-navbar a {
      color: #e5e7eb;
      text-decoration: none;
      font-size: 14px;
      margin-left: 14px;
    }

    .tiy-navbar a:hover {
      text-decoration: underline;
    }

    .tiy-container {
      flex: 1;
      display: flex;
      min-height: 0;
    }

    .tiy-editor {
      width: 50%;
      background: #0f172a;
      border-right: 2px solid #0ea5e9;
      padding: 16px;
      box-sizing: border-box;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .tiy-editor h2 {
      margin: 0 0 4px;
      font-size: 18px;
    }

    .tiy-tabs {
      display: flex;
      gap: 6px;
      margin-bottom: 4px;
    }

    .tiy-tab {
      padding: 4px 10px;
      font-size: 12px;
      border-radius: 999px;
      border: 1px solid #1f2937;
      background: #020617;
      color: #9ca3af;
      cursor: pointer;
    }

    .tiy-tab.active {
      background: #22c55e;
      border-color: #22c55e;
      color: #022c22;
      font-weight: 500;
    }

    .tiy-textarea {
      flex: 1;
      border-radius: 10px;
      border: 1px solid #1f2937;
      background: #020617;
      color: #e5e7eb;
      font-family: "Fira Code", monospace;
      font-size: 13px;
      padding: 10px;
      resize: none;
      outline: none;
    }

    .tiy-run-row {
      margin-top: 8px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 8px;
    }

    .tiy-run-btn {
      padding: 8px 16px;
      border-radius: 999px;
      background: #22c55e;
      border: 1px solid #22c55e;
      color: #022c22;
      font-weight: 600;
      cursor: pointer;
      font-size: 13px;
    }

    .tiy-run-btn:hover {
      background: #16a34a;
    }

    .tiy-reset-btn {
      padding: 6px 12px;
      border-radius: 999px;
      background: transparent;
      border: 1px solid #4b5563;
      color: #e5e7eb;
      font-size: 12px;
      cursor: pointer;
    }

    .tiy-preview {
      width: 50%;
      background: #ffffff;
    }

    .tiy-iframe {
      width: 100%;
      height: 100%;
      border: none;
      background: white;
    }

    @media (max-width: 900px) {
      .tiy-container {
        flex-direction: column;
      }
      .tiy-editor,
      .tiy-preview {
        width: 100%;
        height: 50vh;
      }
    }
</style>
@endpush

  <header class="tiy-navbar">
    <div class="logo">
      <span>IT</span>LAB – Try it Yourself
    </div>
    <nav>
      <a href="{{ route('pages.dashboard') }}">Dashboard</a>
      <a href="{{ route('pages.html') }}">HTML</a>
      <a href="{{ route('pages.css') }}">CSS</a>
      <a href="{{ route('pages.js') }}">JavaScript</a>
    </nav>
  </header>

  <div class="tiy-container">
    <!-- Editor -->
    <section class="tiy-editor">
      <h2 id="tiyTitle">Playground</h2>
      <div class="tiy-tabs">
        <button class="tiy-tab active" data-target="html">HTML</button>
        <button class="tiy-tab" data-target="css">CSS</button>
        <button class="tiy-tab" data-target="js">JavaScript</button>
      </div>

      <textarea id="htmlCode" class="tiy-textarea"></textarea>
      <textarea id="cssCode" class="tiy-textarea" style="display:none;"></textarea>
      <textarea id="jsCode" class="tiy-textarea" style="display:none;"></textarea>

      <div class="tiy-run-row">
        <div>
          <button class="tiy-run-btn" onclick="runCode()">Run ▶</button>
          <button class="tiy-reset-btn" onclick="resetCode()">Reset</button>
        </div>
        <small>Tip: Modify the code according to the track, then press RUN to see the result.</small>
      </div>
    </section>

    <!-- Preview -->
    <section class="tiy-preview">
      <iframe id="previewFrame" class="tiy-iframe"></iframe>
    </section>
  </div>

@push('scripts')
  <script>
    const tabs = document.querySelectorAll(".tiy-tab");
    const htmlArea = document.getElementById("htmlCode");
    const cssArea = document.getElementById("cssCode");
    const jsArea = document.getElementById("jsCode");
    const titleEl = document.getElementById("tiyTitle");

    // Ready-made examples for each page type
    const presets = {
      html: {
        label: "HTML Playground",
        html: `<!DOCTYPE html>
<html>
<head>
  <title>ITLAB – HTML demo</title>
</head>
<body>
  <h1>HTML track example</h1>
  <p>This is a basic HTML page. Try changing the heading or adding more elements.</p>
  <ul>
    <li>Login page</li>
    <li>Dashboard page</li>
    <li>Track pages</li>
  </ul>
</body>
</html>`,
        css: `body {
  font-family: Arial, sans-serif;
  background-color: #f9fafb;
  color: #111827;
  padding: 24px;
}

h1 {
  color: #22c55e;
}`,
        js: `console.log("HTML track playground loaded");`
      },

      css: {
        label: "CSS Playground",
        html: `<!DOCTYPE html>
<html>
<head>
  <title>ITLAB – CSS demo</title>
</head>
<body>
  <div class="card">
    <h1>CSS Track</h1>
    <p>Style this card using the CSS panel.</p>
    <button class="btn">Hover me</button>
  </div>
</body>
</html>`,
        css: `body {
  font-family: Arial, sans-serif;
  background: linear-gradient(135deg, #22c55e, #0ea5e9);
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

.card {
  background: #0b1120;
  color: #e5e7eb;
  padding: 24px 28px;
  border-radius: 16px;
  box-shadow: 0 20px 40px rgba(15, 23, 42, 0.7);
  text-align: center;
}

.btn {
  margin-top: 12px;
  padding: 8px 16px;
  border-radius: 999px;
  border: none;
  background: #22c55e;
  color: #022c22;
  font-weight: 600;
  cursor: pointer;
  transition: transform 0.15s, box-shadow 0.15s, background 0.15s;
}

.btn:hover {
  background: #16a34a;
  transform: translateY(-2px);
  box-shadow: 0 12px 30px rgba(34, 197, 94, 0.5);
}`,
        js: `console.log("CSS track playground loaded");`
      },

      js: {
        label: "JavaScript Playground",
        html: `<!DOCTYPE html>
<html>
<head>
  <title>ITLAB – JS demo</title>
</head>
<body>
  <h1>JavaScript Track</h1>
  <p id="message">Click the button to update this text.</p>
  <button id="btn">Click me</button>
</body>
</html>`,
        css: `body {
  font-family: system-ui, sans-serif;
  padding: 24px;
}

button {
  padding: 8px 14px;
  border-radius: 8px;
  border: none;
  background: #22c55e;
  color: #022c22;
  font-weight: 600;
  cursor: pointer;
}`,
        js: `document.addEventListener("DOMContentLoaded", function () {
  const btn = document.getElementById("btn");
  const msg = document.getElementById("message");

  btn.addEventListener("click", () => {
    msg.textContent = "Nice! You just used JavaScript to change the page 🎉";
  });
});`
      },

      "cyber-network": {
        label: "Network Security Playground",
        html: `<!DOCTYPE html>
<html>
<head>
  <title>ITLAB – Network demo</title>
</head>
<body>
  <h1>Network Security</h1>
  <p>Simulate a simplified "packet log" below.</p>
  <pre id="log"></pre>
  <button id="capture">Capture packet</button>
</body>
</html>`,
        css: `body {
  font-family: monospace;
  background-color: #020617;
  color: #e5e7eb;
  padding: 24px;
}

pre {
  background: #020617;
  border: 1px solid #1e293b;
  padding: 12px;
  border-radius: 8px;
  min-height: 80px;
}

button {
  margin-top: 10px;
  padding: 8px 14px;
  border-radius: 8px;
  border: none;
  background: #0ea5e9;
  color: #0b1120;
  font-weight: 600;
  cursor: pointer;
}`,
        js: `document.addEventListener("DOMContentLoaded", () => {
  const log = document.getElementById("log");
  const btn = document.getElementById("capture");

  btn.addEventListener("click", () => {
    const packet = "Packet from 192.168.0." + Math.floor(Math.random() * 255);
    log.textContent += packet + "\\n";
  });
});`
      },

      "cyber-web": {
        label: "Web Security Playground",
        html: `<!DOCTYPE html>
<html>
<head>
  <title>ITLAB – Web security demo</title>
</head>
<body>
  <h1>Web Application Security</h1>
  <p>Type something into the "comment" and click Render.</p>
  <input id="comment" placeholder="Write a comment..." />
  <button id="render">Render safely</button>

  <h3>Output:</h3>
  <div id="output"></div>
</body>
</html>`,
        css: `body {
  font-family: system-ui, sans-serif;
  padding: 24px;
}

input {
  padding: 6px 10px;
  border-radius: 6px;
  border: 1px solid #9ca3af;
  width: 260px;
}

button {
  margin-left: 8px;
  padding: 6px 12px;
  border-radius: 6px;
  border: none;
  background: #22c55e;
  color: #022c22;
  cursor: pointer;
}

#output {
  margin-top: 12px;
  padding: 10px;
  border-radius: 8px;
  background: #f3f4f6;
}`,
        js: `document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById("comment");
  const btn = document.getElementById("render");
  const out = document.getElementById("output");

  btn.addEventListener("click", () => {
    // Simple example of XSS prevention: display text as plain text, not HTML
    const safeText = input.value.replace(/</g, "&lt;").replace(/>/g, "&gt;");
    out.innerHTML = safeText;
  });
});`
      }
    };

    let currentType = "html";

    tabs.forEach(tab => {
      tab.addEventListener("click", () => {
        tabs.forEach(t => t.classList.remove("active"));
        tab.classList.add("active");

        const target = tab.dataset.target;
        htmlArea.style.display = target === "html" ? "block" : "none";
        cssArea.style.display = target === "css" ? "block" : "none";
        jsArea.style.display = target === "js" ? "block" : "none";
      });
    });

    function applyPreset(type) {
      if (!presets[type]) type = "html";
      currentType = type;

      const preset = presets[type];
      titleEl.textContent = preset.label;

      htmlArea.value = preset.html;
      cssArea.value = preset.css;
      jsArea.value = preset.js;

      // Default tab
      let defaultTab = "html";
      if (type === "css") defaultTab = "css";
      if (type === "js") defaultTab = "js";

      tabs.forEach(t => {
        t.classList.toggle("active", t.dataset.target === defaultTab);
      });

      htmlArea.style.display = defaultTab === "html" ? "block" : "none";
      cssArea.style.display = defaultTab === "css" ? "block" : "none";
      jsArea.style.display = defaultTab === "js" ? "block" : "none";

      runCode();
    }

    function runCode() {
      const html = htmlArea.value;
      const css = "<style>" + cssArea.value + "</style>";
      const js = "<script>" + jsArea.value + "<\\/script>";

      const doc = document.getElementById("previewFrame").contentWindow.document;
      doc.open();
      doc.write(html + css + js);
      doc.close();
    }

    function resetCode() {
      applyPreset(currentType);
    }

    // Use server-provided default if available
    const initialType = "{{ $type ?? 'html' }}";
    applyPreset(initialType);
  </script>
@endpush

@endsection
