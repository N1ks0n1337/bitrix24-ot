BX.ready(function() {
    // Собираем ID всех карточек на канбане
    var cards = document.querySelectorAll('.main-kanban-item');
    var dealIds = [];

    cards.forEach(function(card) {
        var dealId = card.getAttribute('data-id');
        if (dealId) {
            dealIds.push(dealId);
        }
    });

    if (dealIds.length > 0) {
        // Делаем AJAX-запрос для получения цветов сделок
        BX.ajax.runAction('akron.cardcolor:deal.api.getColors', {
            data: {
                dealIds: dealIds
            }
        }).then(function(response) {
            var colors = response.data.colors;

            cards.forEach(function(card) {
                var dealId = card.getAttribute('data-id');
                var colorValue = colors[dealId];

                if (colorValue) {
                    var color;
                    switch (colorValue) {
                        case '26062': // зеленый
                            color = '#dff0d8';
                            break;
                        case '26063': // желтый
                            color = '#fcf8e3';
                            break;
                        case '26064': // красный
                            color = '#f2dede';
                            break;
                        default:
                            color = '';
                    }
                    if (color) {
                        card.style.backgroundColor = color;
                    }
                }
            });
        });
    }
});
