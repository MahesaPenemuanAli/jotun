// Render background colors for swatches in catalog & details
document.querySelectorAll("[data-color]").forEach((element) => {
    element.style.backgroundColor = element.dataset.color || "#FDB913";
});

// ─── INTEGRATED PAINT CALCULATOR (LANDING PAGE & CALCULATOR PAGE) ────────
const calculator = document.querySelector("[data-paint-calculator]");
if (calculator) {
    const lengthInput = calculator.querySelector('[name="panjang_dinding"]');
    const heightInput = calculator.querySelector('[name="tinggi_dinding"]');
    const spreadInput = calculator.querySelector('[name="daya_sebar"]');
    const coatsInput = calculator.querySelector('[name="jumlah_lapisan"]');
    const litersOutput = calculator.querySelector("[data-liters-output]");
    const cansOutput = calculator.querySelector("[data-cans-output]");

    const calculatePaint = () => {
        const length = Number.parseFloat(lengthInput?.value || "0");
        const height = Number.parseFloat(heightInput?.value || "0");
        const spread = Number.parseFloat(spreadInput?.value || "10");
        const coats = Number.parseFloat(coatsInput?.value || "2");
        const area = Math.max(length, 0) * Math.max(height, 0) * Math.max(coats, 1);
        const liters = spread > 0 ? area / spread : 0;
        const cans = Math.max(1, Math.ceil(liters / 2.5));

        if (litersOutput) {
            litersOutput.textContent = `${liters.toFixed(1)} liter`;
        }
        if (cansOutput) {
            cansOutput.textContent = `${cans} kaleng ukuran 2.5L`;
        }
    };

    calculator.addEventListener("input", calculatePaint);
    calculator.addEventListener("change", calculatePaint);
    calculatePaint();
}

// ─── CALCULATOR PAGE: WALL SVG VISUALIZATION ────────────────────────────
const calcForm = document.querySelector("[data-paint-calculator-form]");
if (calcForm) {
    const fLength = calcForm.querySelector('#panjang_dinding');
    const fHeight = calcForm.querySelector('#tinggi_dinding');
    const fCoats = calcForm.querySelector('#jumlah_lapisan');
    const fProduct = calcForm.querySelector('#id_produk');
    
    const wallRect = document.getElementById('wallRect');
    const wallWidthLabel = document.getElementById('wallWidthLabel');
    const wallHeightLabel = document.getElementById('wallHeightLabel');
    const wallAreaLabel = document.getElementById('wallAreaLabel');
    const calcArea = document.getElementById('calcArea');
    const calcPaintArea = document.getElementById('calcPaintArea');
    const calcLiters = document.getElementById('calcLiters');
    const calcCans = document.getElementById('calcCans');

    const calcRecommendation = document.getElementById('calcRecommendation');

    const calculateCanCombo = (liters, sizes) => {
        if (!sizes || sizes.length === 0) {
            const c = Math.max(1, Math.ceil(liters / 2.5));
            return { items: [{ liter: 2.5, count: c, harga: null }], total: c * 2.5, cans: c };
        }
        const sorted = [...sizes].sort((a, b) => b.liter - a.liter);
        let remaining = liters;
        const items = [];
        let total = 0, cans = 0;

        for (const s of sorted) {
            const count = Math.floor(remaining / s.liter);
            if (count > 0) {
                items.push({ liter: s.liter, count, harga: s.harga });
                remaining -= count * s.liter;
                total += count * s.liter;
                cans += count;
            }
        }
        if (remaining > 0.01) {
            const sortedAsc = [...sizes].sort((a, b) => a.liter - b.liter);
            const fit = sortedAsc.find(s => s.liter >= remaining) || sortedAsc[sortedAsc.length - 1];
            const existing = items.find(i => i.liter === fit.liter);
            if (existing) { existing.count++; } else { items.push({ liter: fit.liter, count: 1, harga: fit.harga }); }
            total += fit.liter;
            cans++;
        }
        items.sort((a, b) => b.liter - a.liter);
        return { items, total: Math.round(total * 10) / 10, cans };
    };

    const updateCalcViz = () => {
        const l = Math.max(parseFloat(fLength?.value) || 0, 0.1);
        const h = Math.max(parseFloat(fHeight?.value) || 0, 0.1);
        const coats = parseInt(fCoats?.value) || 2;
        const selectedOption = fProduct?.selectedOptions[0];
        const spread = parseFloat(selectedOption?.dataset?.spread || '10');

        let sizes = [];
        try { sizes = JSON.parse(selectedOption?.dataset?.sizes || '[]'); } catch (e) {}

        const area = l * h;
        const paintArea = area * coats;
        const liters = spread > 0 ? paintArea / spread : 0;
        const combo = calculateCanCombo(liters, sizes);

        // Update SVG proportions
        const maxW = 240, maxH = 160;
        const ratio = l / h;
        let rw, rh;
        if (ratio > maxW / maxH) { rw = maxW; rh = maxW / ratio; } else { rh = maxH; rw = maxH * ratio; }
        const rx = (300 - rw) / 2;
        const ry = (180 - rh) / 2 + 10;

        if (wallRect) { wallRect.setAttribute('x', rx); wallRect.setAttribute('y', ry); wallRect.setAttribute('width', rw); wallRect.setAttribute('height', rh); }
        if (wallWidthLabel) { wallWidthLabel.textContent = `${l.toFixed(1)} m`; wallWidthLabel.setAttribute('x', rx + rw / 2); wallWidthLabel.setAttribute('y', ry + rh + 18); }
        if (wallHeightLabel) { wallHeightLabel.textContent = `${h.toFixed(1)} m`; const hx = rx - 12; const hy = ry + rh / 2; wallHeightLabel.setAttribute('x', hx); wallHeightLabel.setAttribute('y', hy); wallHeightLabel.setAttribute('transform', `rotate(-90, ${hx}, ${hy})`); }
        if (wallAreaLabel) { wallAreaLabel.textContent = `${area.toFixed(1)} m²`; wallAreaLabel.setAttribute('x', rx + rw / 2); wallAreaLabel.setAttribute('y', ry + rh / 2 + 6); }

        if (calcArea) calcArea.textContent = area.toFixed(1);
        if (calcPaintArea) calcPaintArea.textContent = paintArea.toFixed(1);
        if (calcLiters) calcLiters.textContent = liters.toFixed(1);
        if (calcCans) calcCans.textContent = combo.cans;

        if (calcRecommendation) {
            const sisa = Math.max(0, combo.total - liters).toFixed(1);
            let html = combo.items.map(i => `<strong>${i.count}x ${i.liter}L</strong>`).join(' + ');
            html += ` · Total: ${combo.total}L · Sisa: ~${sisa}L`;
            calcRecommendation.innerHTML = html;
        }
    };

    fLength?.addEventListener('input', updateCalcViz);
    fHeight?.addEventListener('input', updateCalcViz);
    fCoats?.addEventListener('change', updateCalcViz);
    fProduct?.addEventListener('change', updateCalcViz);
    updateCalcViz();
}

// ─── JOTUN COLOR STUDIO - TINTING MIXER & INTERACTIVE SYSTEM ─────────────
const studioForm = document.querySelector("[data-tinting-studio-form]");
if (studioForm) {
    const productCards = studioForm.querySelectorAll("[data-product-card-id]");
    const colorChips = studioForm.querySelectorAll("[data-color-chip-id]");
    const hiddenProductInput = studioForm.querySelector("#selectedProductInput");
    const hiddenColorInput = studioForm.querySelector("#selectedColorInput");

    const sliderLightness = studioForm.querySelector("#sliderLightness");
    const sliderWarmth = studioForm.querySelector("#sliderWarmth");
    const lightnessValText = studioForm.querySelector("#lightnessVal");
    const warmthValText = studioForm.querySelector("#warmthVal");

    const roomCanvas = studioForm.querySelector("#roomPreviewCanvas");
    const activeColorBadge = studioForm.querySelector("#activeColorBadge");

    const canQtyInput = studioForm.querySelector("#jumlah_kaleng");
    const canSizeSelect = studioForm.querySelector("#can_size");
    const priceEstimateText = studioForm.querySelector("#studioPriceEstimate");

    const barBase = studioForm.querySelector("#formulaBase");
    const barBaseText = studioForm.querySelector("#formulaBaseText");
    const barTintA = studioForm.querySelector("#formulaTintA");
    const barTintAText = studioForm.querySelector("#formulaTintAText");
    const barTintB = studioForm.querySelector("#formulaTintB");
    const barTintBText = studioForm.querySelector("#formulaTintBText");

    const colorCountInfo = document.getElementById("colorCountInfo");
    const colorNoResults = document.getElementById("colorNoResults");
    const colorGridContainer = document.getElementById("colorGridContainer");
    const colorSelectPrompt = document.getElementById("colorSelectPrompt");

    let state = {
        selectedProductId: "",
        selectedProductPrice: 0,
        selectedColorId: "",
        selectedColorHex: "#E5E7EB",
        selectedColorName: "",
        selectedColorCode: "",
        lightness: 100,
        warmth: 0
    };

    const resetSelectedColorPreview = (message = "Pilih warna dari grid di atas") => {
        state.selectedColorId = "";
        state.selectedColorHex = "#E5E7EB";
        state.selectedColorName = "";
        state.selectedColorCode = "";

        if (hiddenColorInput) hiddenColorInput.value = "";

        colorChips.forEach((chip) => chip.classList.remove("active"));

        const previewSwatch = studioForm.querySelector("#previewColorSwatch");
        const previewCategory = studioForm.querySelector("#previewColorCategory");
        const previewName = studioForm.querySelector("#previewColorName");
        const previewCode = studioForm.querySelector("#previewColorCode");

        if (previewSwatch) previewSwatch.style.backgroundColor = "#E5E7EB";
        if (previewCategory) previewCategory.textContent = "—";
        if (previewName) previewName.textContent = message;
        if (previewCode) previewCode.textContent = "—";
        if (activeColorBadge) activeColorBadge.textContent = "Belum ada warna dipilih";
    };

    const hexToHsl = (hex) => {
        let r = parseInt(hex.slice(1, 3), 16) / 255;
        let g = parseInt(hex.slice(3, 5), 16) / 255;
        let b = parseInt(hex.slice(5, 7), 16) / 255;
        let max = Math.max(r, g, b), min = Math.min(r, g, b);
        let h, s, l = (max + min) / 2;
        if (max === min) { h = s = 0; }
        else {
            let d = max - min;
            s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
            switch (max) {
                case r: h = (g - b) / d + (g < b ? 6 : 0); break;
                case g: h = (b - r) / d + 2; break;
                case b: h = (r - g) / d + 4; break;
            }
            h /= 6;
        }
        return { h: Math.round(h * 360), s: Math.round(s * 100), l: Math.round(l * 100) };
    };

    const updateCanvasColor = () => {
        if (!state.selectedColorHex || state.selectedColorHex === "#E5E7EB") return;
        const baseHsl = hexToHsl(state.selectedColorHex);
        let targetL = Math.max(10, Math.min(95, baseHsl.l * (state.lightness / 100)));
        let targetH = baseHsl.h;
        let targetS = baseHsl.s;
        if (state.warmth > 0) {
            targetH = targetH + ((45 - targetH) * (state.warmth / 60));
            targetS = Math.min(100, targetS + (state.warmth * 0.3));
        } else if (state.warmth < 0) {
            targetH = targetH + ((210 - targetH) * (Math.abs(state.warmth) / 60));
            targetS = Math.min(100, targetS + (Math.abs(state.warmth) * 0.15));
        }
        if (roomCanvas) roomCanvas.style.backgroundColor = `hsl(${Math.round(targetH)}, ${Math.round(targetS)}%, ${Math.round(targetL)}%)`;
        if (activeColorBadge) {
            let label = `${state.selectedColorName} (${state.selectedColorCode})`;
            if (state.lightness !== 100 || state.warmth !== 0) label += " - Racikan Kustom";
            activeColorBadge.textContent = label;
        }
    };

    const updatePigmentFormula = () => {
        let warmthOffset = Math.abs(state.warmth);
        let lightnessOffset = Math.abs(state.lightness - 100);
        let basePct = Math.round(Math.max(82, Math.min(99, 100 - (warmthOffset * 0.3) - (lightnessOffset * 0.15))));
        let tintAPct = Math.round(Math.max(1, Math.min(12, (state.warmth > 0 ? warmthOffset * 0.35 : 1) + (lightnessOffset * 0.05))));
        let tintBPct = Math.round(100 - basePct - tintAPct);
        if (barBase && barBaseText) { barBase.style.width = `${basePct}%`; barBaseText.textContent = `${basePct}%`; }
        if (barTintA && barTintAText) { barTintA.style.width = `${tintAPct}%`; barTintAText.textContent = `${tintAPct}%`; }
        if (barTintB && barTintBText) { barTintB.style.width = `${tintBPct}%`; barTintBText.textContent = `${tintBPct}%`; }
    };

    const updatePriceEstimate = () => {
        const qty = parseInt(canQtyInput?.value || "1");
        const sizeMultiplier = canSizeSelect?.value === "20" ? 7.5 : 1.0;
        const totalPrice = state.selectedProductPrice * sizeMultiplier * qty;
        if (priceEstimateText) priceEstimateText.textContent = `Rp${totalPrice.toLocaleString("id-ID")}`;
    };

    let currentSearch = "";
    let currentCategory = "all";

    const applyColorFilters = () => {
        let visibleCount = 0;
        let firstVisibleChip = null;

        colorChips.forEach((chip) => {
            const chipProduct = chip.dataset.colorChipProduct;
            const chipName = (chip.dataset.colorChipName || "").toLowerCase();
            const chipCode = (chip.dataset.colorChipCode || "").toLowerCase();
            const chipCategory = (chip.dataset.colorChipCategory || "").trim().toLowerCase();

            const matchesProduct = chipProduct === state.selectedProductId;
            const matchesSearch = currentSearch === "" || chipName.includes(currentSearch) || chipCode.includes(currentSearch);
            const matchesCategory = currentCategory === "all" || chipCategory === currentCategory.toLowerCase();

            if (matchesProduct && matchesSearch && matchesCategory) {
                chip.style.display = "block";
                chip.classList.remove("hidden");
                visibleCount++;
                if (!firstVisibleChip) firstVisibleChip = chip;
            } else {
                chip.style.display = "none";
                chip.classList.add("hidden");
            }
        });

        // Show/hide no-results and color count
        if (colorNoResults) colorNoResults.style.display = (state.selectedProductId && visibleCount === 0) ? "block" : "none";
        if (colorGridContainer) colorGridContainer.style.display = state.selectedProductId ? "grid" : "none";
        if (colorSelectPrompt) colorSelectPrompt.style.display = state.selectedProductId ? "none" : "block";
        if (colorCountInfo) colorCountInfo.textContent = state.selectedProductId ? `${visibleCount} warna tersedia` : "";

        // Auto-select first visible if current is not visible
        const currentStillVisible = Array.from(colorChips).find(
            (c) => c.dataset.colorChipId === state.selectedColorId && !c.classList.contains("hidden")
        );

        if (firstVisibleChip && !currentStillVisible) {
            firstVisibleChip.click();
        }

        if (!firstVisibleChip) {
            resetSelectedColorPreview("Tidak ada warna yang cocok dengan filter Anda");
        }
    };

    const selectProduct = (productId, price) => {
        state.selectedProductId = productId;
        state.selectedProductPrice = Number(price);
        if (hiddenProductInput) hiddenProductInput.value = productId;

        // Reset color selection
        state.selectedColorId = "";
        if (hiddenColorInput) hiddenColorInput.value = "";
        resetSelectedColorPreview();

        productCards.forEach((card) => {
            card.classList.toggle("active", card.dataset.productCardId === productId);
        });

        applyColorFilters();
        updatePriceEstimate();
    };

    const selectColor = (chipId, hex, name, code, category) => {
        state.selectedColorId = chipId;
        state.selectedColorHex = hex;
        state.selectedColorName = name;
        state.selectedColorCode = code;
        if (hiddenColorInput) hiddenColorInput.value = chipId;

        colorChips.forEach((chip) => {
            chip.classList.toggle("active", chip.dataset.colorChipId === chipId);
        });

        const previewSwatch = studioForm.querySelector("#previewColorSwatch");
        const previewCategory = studioForm.querySelector("#previewColorCategory");
        const previewName = studioForm.querySelector("#previewColorName");
        const previewCode = studioForm.querySelector("#previewColorCode");
        if (previewSwatch) previewSwatch.style.backgroundColor = hex;
        if (previewCategory) previewCategory.textContent = (category || "NETRAL").toUpperCase();
        if (previewName) previewName.textContent = name;
        if (previewCode) previewCode.textContent = code;

        updateCanvasColor();
        updatePigmentFormula();
    };

    // ─── ATTACH EVENTS ───
    productCards.forEach((card) => {
        card.addEventListener("click", () => selectProduct(card.dataset.productCardId, card.dataset.productPrice));
    });

    colorChips.forEach((chip) => {
        chip.addEventListener("click", () => selectColor(chip.dataset.colorChipId, chip.dataset.colorChipHex, chip.dataset.colorChipName, chip.dataset.colorChipCode, chip.dataset.colorChipCategory));
    });

    const searchInput = studioForm.querySelector("#colorSearch");
    if (searchInput) {
        searchInput.addEventListener("input", (e) => { currentSearch = e.target.value.toLowerCase().trim(); applyColorFilters(); });
    }

    const filterPills = studioForm.querySelectorAll(".filter-pill");
    filterPills.forEach((pill) => {
        pill.addEventListener("click", () => {
            filterPills.forEach(p => p.classList.remove("active"));
            pill.classList.add("active");
            currentCategory = pill.dataset.filter;
            applyColorFilters();
        });
    });

    sliderLightness?.addEventListener("input", (e) => { state.lightness = Number(e.target.value); if (lightnessValText) lightnessValText.textContent = `${state.lightness}%`; updateCanvasColor(); updatePigmentFormula(); });
    sliderWarmth?.addEventListener("input", (e) => { state.warmth = Number(e.target.value); if (warmthValText) { if (state.warmth > 0) warmthValText.textContent = `+${state.warmth} Warm`; else if (state.warmth < 0) warmthValText.textContent = `${state.warmth} Cool`; else warmthValText.textContent = "Karakter Asli"; } updateCanvasColor(); updatePigmentFormula(); });
    canQtyInput?.addEventListener("input", updatePriceEstimate);
    canSizeSelect?.addEventListener("change", updatePriceEstimate);

    // Initialize
    const initialActiveCard = studioForm.querySelector(".studio-product-card.active");
    if (initialActiveCard) {
        selectProduct(initialActiveCard.dataset.productCardId, initialActiveCard.dataset.productPrice);
    }
}

