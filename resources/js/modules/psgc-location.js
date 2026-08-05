/**
 * PSGC Location Selector Module
 * Dynamically fetches Misamis Oriental Cities/Municipalities & Barangays via PSGC API.
 */
export function initPsgcLocationSelector() {
  const citySelect = document.getElementById('modalCity');
  const barangaySelect = document.getElementById('modalBarangay');
  if (!citySelect || !barangaySelect) return;

  const oldCity = citySelect.dataset.old || 'Balingasag';
  const oldBarangay = barangaySelect.dataset.old || '';

  // PSGC API Endpoint for Misamis Oriental Cities/Municipalities (Province Code: 104300000)
  const PROVINCE_CODE_MIS_OR = '104300000';

  const loadBarangaysForCity = (cityCode) => {
    barangaySelect.disabled = false;
    barangaySelect.innerHTML = '<option value="">Loading Barangays...</option>';

    fetch(`https://psgc.gitlab.io/api/cities-municipalities/${cityCode}/barangays.json`)
      .then(response => response.json())
      .then(data => {
        barangaySelect.innerHTML = '<option value="">Select Barangay...</option>';
        if (Array.isArray(data)) {
          data.sort((a, b) => a.name.localeCompare(b.name)).forEach(brgy => {
            const opt = document.createElement('option');
            opt.value = brgy.name;
            opt.textContent = brgy.name;
            if (oldBarangay && oldBarangay === brgy.name) opt.selected = true;
            barangaySelect.appendChild(opt);
          });
        }
      })
      .catch(err => {
        console.error('Error fetching PSGC barangays:', err);
        barangaySelect.innerHTML = '<option value="">Error loading barangays</option>';
      });
  };

  // Dynamically fetch Misamis Oriental Cities/Municipalities via PSGC API
  fetch(`https://psgc.gitlab.io/api/provinces/${PROVINCE_CODE_MIS_OR}/cities-municipalities.json`)
    .then(response => response.json())
    .then(cities => {
      citySelect.innerHTML = '';
      cities.sort((a, b) => a.name.localeCompare(b.name));

      let activeCityCode = null;

      cities.forEach(city => {
        const opt = document.createElement('option');
        opt.value = city.name;
        opt.dataset.code = city.code;
        opt.textContent = city.name;

        // Pre-select Balingasag by default or user's previous selection
        if (oldCity ? city.name === oldCity : city.name === 'Balingasag') {
          opt.selected = true;
          activeCityCode = city.code;
        }
        citySelect.appendChild(opt);
      });

      // Load Barangays for the selected city
      if (activeCityCode) {
        loadBarangaysForCity(activeCityCode);
      } else if (cities.length > 0) {
        loadBarangaysForCity(cities[0].code);
      }
    })
    .catch(err => {
      console.error('Error fetching PSGC cities:', err);
      citySelect.innerHTML = '<option value="Balingasag" data-code="104305000">Balingasag</option>';
      loadBarangaysForCity('104305000');
    });

  // When user changes City / Municipality
  citySelect.addEventListener('change', function () {
    const selectedOption = citySelect.options[citySelect.selectedIndex];
    const cityCode = selectedOption ? selectedOption.dataset.code : null;
    if (cityCode) {
      loadBarangaysForCity(cityCode);
    }
  });
}
