<?php
use Bitrix\Main\Loader;

Loader::includeModule('iblock');

class BookingProcedureProp
{
    public static function GetUserTypeDescription()
    {
        return [
            'PROPERTY_TYPE'        => 'S',
            'USER_TYPE'            => 'BookingProcedure',
            'DESCRIPTION'          => 'Процедура (popup)',
            'GetPropertyFieldHtml' => ['BookingProcedureProp', 'GetPropertyFieldHtml'],
            'GetAdminListViewHTML' => ['BookingProcedureProp', 'GetAdminListViewHTML'],
        ];
    }

    public static function GetPropertyFieldHtml($arProperty, $value, $htmlControlName)
    {
        $propId    = (int)$arProperty['ID'];
        $fieldId   = 'prop_' . $propId . '_procedure';
        $fieldName = $htmlControlName['VALUE'];

        $selectedId   = (int)($value['VALUE'] ?? 0);
        $selectedName = self::getProcedureName($selectedId);

        $html  = '<input type="hidden" '
            . 'id="' . $fieldId . '" '
            . 'name="' . htmlspecialchars($fieldName, ENT_QUOTES) . '" '
            . 'value="' . $selectedId . '">';
        $html .= '<button type="button" id="' . $fieldId . '_btn">'
            . 'Выбрать процедуру'
            . '</button> ';
        $html .= '<span id="' . $fieldId . '_disp">'
            . htmlspecialchars($selectedName, ENT_QUOTES)
            . '</span>';

        $iblockId     = (int)($_REQUEST['IBLOCK_ID'] ?? 0);
        $doctorPropId = 0;
        if ($iblockId > 0) {
            $rs = \CIBlockProperty::GetList([], [
                'IBLOCK_ID' => $iblockId,
                'CODE'      => 'DOCTOR_ID',
            ]);
            if ($p = $rs->Fetch()) {
                $doctorPropId = (int)$p['ID'];
            }
        }

        $html .= '<script>
BX.ready(function(){
    var btn = BX("' . $fieldId . '_btn");
    if (!btn) return;
    BX.bind(btn, "click", function(){
        var selector = \'input[name^="PROP[' . $doctorPropId . ']"]\';
        var doctorField = document.querySelector(selector);
        var doctorId = doctorField ? doctorField.value : "";
        if (!doctorId) {
            alert("Сначала выберите врача");
            return;
        }

        BX.ajax({
            url: "/local/php_interface/get_procedures.php",
            method: "POST",
            dataType: "json",
            data: { doctor_id: doctorId },
            onsuccess: function(response){
                var html = "<ul style=\'list-style:none;margin:0;padding:0;\'>";
                response.forEach(function(item){
                    html += "<li data-id=\'"+item.ID+"\' "
                          + "style=\'padding:4px;cursor:pointer;border-bottom:1px solid #ddd;\'>"
                          + BX.util.htmlspecialchars(item.NAME) + "</li>";
                });
                html += "</ul>";

                var popup = BX.PopupWindowManager.create(
                    "proc_popup_' . $fieldId . '",
                    null,
                    {
                        autoHide: true,
                        closeIcon: true,
                        overlay: { backgroundColor: "#000", opacity: 0.5 },
                        content: BX.create("div", { html: html })
                    }
                );
                popup.show();

                var items = popup.popupContainer.getElementsByTagName("li");
                for (var i=0; i<items.length; i++) {
                    BX.bind(items[i], "click", function(){
                        var id = this.getAttribute("data-id");
                        var name = this.innerText;
                        BX("' . $fieldId . '").value       = id;
                        BX("' . $fieldId . '_disp").innerText = name;
                        popup.close();
                    });
                }
            },
            onfailure: function(){
                alert("Ошибка при загрузке списка процедур");
            }
        });
    });
});
</script>';

        return $html;
    }

    public static function GetAdminListViewHTML($arProperty, $value, $strHTMLControlName)
    {
        return htmlspecialchars(self::getProcedureName((int)$value['VALUE']), ENT_QUOTES);
    }

    private static function getProcedureName(int $id): string
    {
        if ($id <= 0) {
            return "";
        }
        $res = \CIBlockElement::GetByID($id);
        if ($elem = $res->GetNext()) {
            return $elem['NAME'];
        }
        return "";
    }
}
