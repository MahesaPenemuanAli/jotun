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

    const updateCalcViz = () => {
        const l = Math.max(parseFloat(fLength?.value) || 0, 0.1);
        const h = Math.max(parseFloat(fHeight?.value) || 0, 0.1);
        const coats = parseInt(fCoats?.value) || 2;
        const selectedOption = fProduct?.selectedOptions[0];
        const spread = parseFloat(selectedOption?.dataset?.spread || '10');

        const area = l * h;
        const paintArea = area * coats;
        const liters = spread > 0 ? paintArea / spread : 0;
        const cans = Math.max(1, Math.ceil(liters / 2.5));

        // Update SVG proportions (maintain within 300x200 viewbox)
        const maxW = 240, maxH = 160;
        const ratio = l / h;
        let rw, rh;
        if (ratio > maxW / maxH) {
            rw = maxW;
            rh = maxW / ratio;
        } else {
            rh = maxH;
            rw = maxH * ratio;
        }
        const rx = (300 - rw) / 2;
        const ry = (180 - rh) / 2 + 10;

        if (wallRect) {
            wallRect.setAttribute('x', rx);
            wallRect.setAttribute('y', ry);
            wallRect.setAttribute('width', rw);
            wallRect.setAttribute('height', rh);
        }
        if (wallWidthLabel) {
            wallWidthLabel.textContent = `${l.toFixed(1)} m`;
            wallWidthLabel.setAttribute('x', rx + rw / 2);
            wallWidthLabel.setAttribute('y', ry + rh + 18);
        }
        if (wallHeightLabel) {
            wallHeightLabel.textContent = `${h.toFixed(1)} m`;
            const hx = rx - 12;
            const hy = ry + rh / 2;
            wallHeightLabel.setAttribute('x', hx);
            wallHeightLabel.setAttribute('y', hy);
            wallHeightLabel.setAttribute('transform', `rotate(-90, ${hx}, ${hy})`);
        }
        if (wallAreaLabel) {
            wallAreaLabel.textContent = `${area.toFixed(1)} m²`;
            wallAreaLabel.setAttribute('x', rx + rw / 2);
            wallAreaLabel.setAttribute('y', ry + rh / 2 + 6);
        }

        // Update result cards
        if (calcArea) calcArea.textContent = area.toFixed(1);
        if (calcPaintArea) calcPaintArea.textContent = paintArea.toFixed(1);
        if (calcLiters) calcLiters.textContent = liters.toFixed(1);
        if (calcCans) calcCans.textContent = cans;
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
    const hiddenProductSelect = studioForm.querySelector("#id_produk");
    const hiddenColorSelect = studioForm.querySelector("#id_warna");

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

    let state = {
        selectedProductId: "",
        selectedProductPrice: 0,
        selectedColorId: "",
        selectedColorHex: "#F8F5EC",
        selectedColorName: "Classic White",
        selectedColorCode: "JTN-001",
        lightness: 100, // percentage (40 to 160)
        warmth: 0 // offset (-30 to 30)
    };

    // Color conversion utility: HEX to HSL
    const hexToHsl = (hex) => {
        let r = parseInt(hex.slice(1, 3), 16) / 255;
        let g = parseInt(hex.slice(3, 5), 16) / 255;
        let b = parseInt(hex.slice(5, 7), 16) / 255;
        let max = Math.max(r, g, b), min = Math.min(r, g, b);
        let h, s, l = (max + min) / 2;

        if (max === min) {
            h = s = 0; // achromatic
        } else {
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

    // Update Room Visualizer Canvas Color
    const updateCanvasColor = () => {
        const baseHsl = hexToHsl(state.selectedColorHex);
        
        // 1. Process Lightness manipulation
        let targetL = Math.max(10, Math.min(95, baseHsl.l * (state.lightness / 100)));
        
        // 2. Process Warmth manipulation (shift Hue slightly towards yellow/warm: ~35 deg or cool: ~210 deg)
        let targetH = baseHsl.h;
        let targetS = baseHsl.s;

        if (state.warmth > 0) {
            // Shift towards warm yellow (approx 45 degrees)
            const diff = 45 - targetH;
            targetH = targetH + (diff * (state.warmth / 60));
            targetS = Math.min(100, targetS + (state.warmth * 0.3));
        } else if (state.warmth < 0) {
            // Shift towards cool blue (approx 210 degrees)
            const diff = 210 - targetH;
            targetH = targetH + (diff * (Math.abs(state.warmth) / 60));
            targetS = Math.min(100, targetS + (Math.abs(state.warmth) * 0.15));
        }

        // Apply updated HSL background to canvas container
        if (roomCanvas) {
            roomCanvas.style.backgroundColor = `hsl(${Math.round(targetH)}, ${Math.round(targetS)}%, ${Math.round(targetL)}%)`;
        }

        // Update badge caption
        if (activeColorBadge) {
            let label = `${state.selectedColorName} (${state.selectedColorCode})`;
            if (state.lightness !== 100 || state.warmth !== 0) {
                label += " - Racikan Kustom";
            }
            activeColorBadge.textContent = label;
        }
    };

    // Calculate Pigment Composition Bars
    const updatePigmentFormula = () => {
        // Mock a realistic chemical dispenser logic based on sliders
        let warmthOffset = Math.abs(state.warmth);
        let lightnessOffset = Math.abs(state.lightness - 100);

        let basePct = Math.max(82, Math.min(99, 100 - (warmthOffset * 0.3) - (lightnessOffset * 0.15)));
        let tintAPct = Math.max(1, Math.min(12, (state.warmth > 0 ? warmthOffset * 0.35 : 1) + (lightnessOffset * 0.05)));
        let tintBPct = Math.round(100 - basePct - tintAPct);

        basePct = Math.round(basePct);
        tintAPct = Math.round(tintAPct);

        if (barBase && barBaseText) {
            barBase.style.width = `${basePct}%`;
            barBaseText.textContent = `${basePct}%`;
        }
        if (barTintA && barTintAText) {
            barTintA.style.width = `${tintAPct}%`;
            barTintAText.textContent = `${tintAPct}%`;
        }
        if (barTintB && barTintBText) {
            barTintB.style.width = `${tintBPct}%`;
            barTintBText.textContent = `${tintBPct}%`;
        }
    };

    // Calculate Price Estimate
    const updatePriceEstimate = () => {
        const qty = parseInt(canQtyInput?.value || "1");
        const sizeMultiplier = canSizeSelect?.value === "20" ? 7.5 : 1.0; // 7.5x price instead of 8x for bulk discount
        const totalPrice = state.selectedProductPrice * sizeMultiplier * qty;

        if (priceEstimateText) {
            priceEstimateText.textContent = `Rp${totalPrice.toLocaleString("id-ID")}`;
        }
    };

    // Product Selection handler
    const selectProduct = (productId, price) => {
        state.selectedProductId = productId;
        state.selectedProductPrice = Number(price);

        // Sync hidden select
        if (hiddenProductSelect) {
            hiddenProductSelect.value = productId;
        }

        // Toggle card visual active states
        productCards.forEach((card) => {
            if (card.dataset.productCardId === productId) {
                card.classList.add("active");
            } else {
                card.classList.remove("active");
            }
        });

        // Filter color chips based on product relation
        let firstVisibleChip = null;
        colorChips.forEach((chip) => {
            const chipProduct = chip.dataset.colorChipProduct;
            if (chipProduct === productId) {
                chip.classList.remove("hidden");
                if (!firstVisibleChip) {
                    firstVisibleChip = chip;
                }
            } else {
                chip.classList.add("hidden");
            }
        });

        // Automatically trigger click on the first color chip of this product
        if (firstVisibleChip) {
            firstVisibleChip.click();
        }

        updatePriceEstimate();
    };

    // Color Chip Selection handler
    const selectColor = (chipId, hex, name, code) => {
        state.selectedColorId = chipId;
        state.selectedColorHex = hex;
        state.selectedColorName = name;
        state.selectedColorCode = code;

        // Sync hidden select option
        if (hiddenColorSelect) {
            hiddenColorSelect.value = chipId;
        }

        // Toggle chip active state
        colorChips.forEach((chip) => {
            if (chip.dataset.colorChipId === chipId) {
                cardBorder = chip.classList.add("active");
            } else {
                chip.classList.remove("active");
            }
        });

        updateCanvasColor();
        updatePigmentFormula();
    };

    // ─── ATTACH EVENTS ───

    // Product cards click event
    productCards.forEach((card) => {
        card.addEventListener("click", () => {
            selectProduct(card.dataset.productCardId, card.dataset.productPrice);
        });
    });

    // Color chips click event
    colorChips.forEach((chip) => {
        chip.addEventListener("click", () => {
            selectColor(
                chip.dataset.colorChipId,
                chip.dataset.colorChipHex,
                chip.dataset.colorChipName,
                chip.dataset.colorChipCode
            );
        });
    });

    // Sliders input event listeners
    sliderLightness?.addEventListener("input", (e) => {
        state.lightness = Number(e.target.value);
        if (lightnessValText) {
            lightnessValText.textContent = `${state.lightness}%`;
        }
        updateCanvasColor();
        updatePigmentFormula();
    });

    sliderWarmth?.addEventListener("input", (e) => {
        state.warmth = Number(e.target.value);
        if (warmthValText) {
            if (state.warmth > 0) warmthValText.textContent = `+${state.warmth} Warm`;
            else if (state.warmth < 0) warmthValText.textContent = `${state.warmth} Cool`;
            else warmthValText.textContent = "Karakter Asli";
        }
        updateCanvasColor();
        updatePigmentFormula();
    });

    // Quantity & Size event listeners
    canQtyInput?.addEventListener("input", updatePriceEstimate);
    canSizeSelect?.addEventListener("change", updatePriceEstimate);

    // Initialize with active card (first card by default)
    const initialActiveCard = studioForm.querySelector(".studio-product-card.active");
    if (initialActiveCard) {
        selectProduct(
            initialActiveCard.dataset.productCardId,
            initialActiveCard.dataset.productPrice
        );
    }
}
