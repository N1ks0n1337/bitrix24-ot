;(function(){
    'use strict';

    BX.ready(function(){
        var confirmed = false;

        document.addEventListener('click', function(e){
            var btn = e.target.closest('.tm-popup-button-handler button.ui-btn-success');
            if(!btn){
                return;
            }

            if(confirmed){
                confirmed = false;
                return;
            }

            e.preventDefault();
            e.stopPropagation();

            var popup = BX.PopupWindowManager.create(
                'tmCustomConfirm',
                btn,
                {
                    autoHide: false,
                    closeByEsc: true,
                    closeIcon: true,
                    overlay: { backgroundColor: '#000', opacity: 50 },
                    titleBar: { content: BX.create('span', { text: 'Подтверждение' }) },
                    content: BX.create('div', {
                        html:
                            '<p>Вы действительно хотите начать рабочий день?</p>' +
                            '<div style="margin-top:15px;text-align:right;">' +
                            '<button id="tmConfirmYes" class="ui-btn ui-btn-success">Да, начать</button>' +
                            '<button id="tmConfirmNo"  class="ui-btn ui-btn-light-border" style="margin-left:8px;">Отмена</button>' +
                            '</div>'
                    })
                }
            );
            popup.show();

            BX.bind(BX('tmConfirmYes'), 'click', function(){
                confirmed = true;
                popup.close();
                btn.click();
            });

            BX.bind(BX('tmConfirmNo'), 'click', function(){
                popup.close();
            });
        }, true);
    });
})();
