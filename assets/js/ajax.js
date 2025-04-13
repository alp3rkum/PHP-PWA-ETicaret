/*
A reusable refactor function for XHR AJAX POST requests
Usage:
const formData = new FormData();
formData.append('key', 'value');
ajaxPOST(formData, '/api/submit-data').then((result) => {
    if (result === "success") {
        alert("İstek başarılı!");
    } else {
        alert("İstek başarısız oldu!");
    }
}
*/
function ajaxPOST(formData, endpoint) {
    return new Promise((resolve) => {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', endpoint, true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        resolve("success");
                    } else {
                        resolve("error");
                    }
                } catch (e) {
                    resolve("error");
                }
            } else {
                resolve("error");
            }
        };

        xhr.onerror = function () {
            resolve("error");
        };

        xhr.send(formData);
    });
}

/*
A reusable function for XHR AJAX GET requests with optional query parameters
Usage:
const params = { key1: 'value1', key2: 'value2' };
ajaxGET('/api/get-data', params).then((result) => {
    if (result.success) {
        console.log("Veri:", result.data);
    } else {
        console.error("Hata:", result.message);
    }
});
*/
function ajaxGET(endpoint, params = {}) {
    return new Promise((resolve) => {
        const queryString = Object.keys(params)
            .map(key => `${encodeURIComponent(key)}=${encodeURIComponent(params[key])}`)
            .join('&');
        
        const fullUrl = queryString ? `${endpoint}?${queryString}` : endpoint;

        const xhr = new XMLHttpRequest();
        xhr.open('GET', fullUrl, true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    resolve({ success: true, data: response });
                } catch (e) {
                    resolve({ success: false, message: "Yanıt çözümlenirken bir hata oluştu: " + e.message });
                }
            } else {
                resolve({ success: false, message: `İstek başarısız oldu. Durum kodu: ${xhr.status}` });
            }
        };

        xhr.onerror = function () {
            resolve({ success: false, message: "Ağ hatası oluştu." });
        };

        xhr.send();
    });
}