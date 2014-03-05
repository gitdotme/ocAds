document.createElement('article');
document.createElement('section');
document.createElement('aside');
document.createElement('hgroup');
document.createElement('nav');
document.createElement('header'); 
document.createElement('footer');
document.createElement('figure');
document.createElement('figcaption');

function goURL(url)
{
    document.location = url;
}

$(document).ready(function(e)
{
    if ($('#fYear').length)
    {
        $("#fYear").slider({
            from: 1980,
            to: 2014,
            step: 1,
            scale: ['Before 1980', '|', '', '|', 2014],
            format: { format: '##', locale: 'en' },
            dimension: '',
            skin: 'plastic',
            onstatechange: function (value)
            {
                var split = value.split(';');
                
                if (split[0] == 1980)
                {
                    $('#fYearMin').val('');
                }
                else
                {
                    $('#fYearMin').val(split[0]);
                }
                
                if (split[1] == 2014)
                {
                    $('#fYearMax').val('');
                }
                else
                {
                    $('#fYearMax').val(split[1]);
                }
            }
        });
    }
    
    if ($('#fYear').length)
    {
        $("#fPrice").slider({
            from: 0,
            to: 50000,
            step: 1000,
            scale: [0, '|', '', '|', '+50.000'],
            dimension: '',
            skin: 'plastic',
            onstatechange: function (value)
            {
                var split = value.split(';');
                
                if (split[0] == 0)
                {
                    $('#fPriceMin').val('');
                }
                else
                {
                    $('#fPriceMin').val(split[0]);
                }
                
                if (split[1] == 50000)
                {
                    $('#fPriceMax').val('');
                }
                else
                {
                    $('#fPriceMax').val(split[1]);
                }
            }
        });
    }
    
    if ($('#fMileage').length)
    {
        $("#fMileage").slider({
            from: 0,
            to: 200000,
            step: 10000,
            scale: [0, '|', '', '|', '+200.000'],
            dimension: '',
            skin: 'plastic',
            onstatechange: function (value)
            {
                var split = value.split(';');
                
                if (split[0] == 0)
                {
                    $('#fMileageMin').val('');
                }
                else
                {
                    $('#fMileageMin').val(split[0]);
                }
                
                if (split[1] == 200000)
                {
                    $('#fMileageMax').val('');
                }
                else
                {
                    $('#fMileageMax').val(split[1]);
                }
            }
        });
    }
    
    if ($('#searchFilter > form').length)
    {
        $('#searchFilter > form').submit(function(e)
        {
            $('#fYear').attr('disabled', 'disabled');
            $('#fPrice').attr('disabled', 'disabled');
            $('#fMileage').attr('disabled', 'disabled');
        });
    }
    
    if ($('#fOrder').length)
    {
        $('#fOrder').change(function()
        {
            document.location = $('#fOrder').attr('data-route') + '?' + $('#fOrder').val();
        });
    }
    
    $(function()
    {
        $('a[rel~=nofollow]').attr('target', '_blank');
        $('a[rel~=external]').attr('target', '_blank');
    });
    
    $('img').each(function()
    {
        $(this).removeAttr('alt');
    });
});