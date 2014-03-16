<div id="editor"></div>
<div style="clear: both;" id="fields"></div>
<pre></pre>

<style type="text/css">
.empty {
  background-color: #FCC;
}
.invalid {
  background-color: #FC6;
}
</style>
<script type="text/javascript">
function newFields() {
  return 'Bracket name [a-z0-9_] <input type="text" id="bracketId" class="empty" /><input type="submit" value="Create" disabled />'
}

function newBracket() {
  $('#editor').empty().bracket({
      save: function(data){
          $('pre').text(jQuery.toJSON(data))
        }
      })
  $('#fields').html(newFields())
}

function refreshSelect(pick) {
  var select = $('#bracketSelect').empty()
  $('<option value="">New bracket</option>').appendTo(select)
  $.getJSON('rest.php?op=list', function(data) {

    $.each(data, function(i, e) {
      select.append('<option value="'+e+'">'+e+'</option>')
    })
  }).success(function() {
    if (pick) {
      select.find(':selected').removeAttr('seleceted')
      select.find('option[value="'+pick+'"]').attr('selected','selected')
      select.change()
    }
  })
}

function hash() {
  var bracket = null
  var parts = window.location.href.replace(/#!([a-z0-9_]+)$/gi, function(m, match) {
    bracket = match
  });
  return bracket;
}

$(document).ready(newBracket)
$(document).ready(function() {
    newBracket()
    $('input#bracketId').live('keyup', function() {
      var input = $(this)
      var submit = $('input[value="Create"]')
      if (input.val().length === 0) {
        input.removeClass('invalid')
        input.addClass('empty')
        submit.attr('disabled', 'disabled')
      }
      else if (input.val().match(/[^0-9a-z_]+/)) {
        input.addClass('invalid')
        submit.attr('disabled', 'disabled')
      }
      else {
        input.removeClass('empty invalid')
        submit.removeAttr('disabled')
      }
    })

    $('input[value="Create"]').live('click', function() {
      $(this).attr('disabled', 'disabled')
      var input = $('input#bracketId')
      var bracketId = input.val()

      if (bracketId.match(/[^0-9a-z_]+/))
        return

      var data = $('#editor').bracket('data')
      var json = jQuery.toJSON(data)
      $.getJSON('rest.php?op=set&id='+bracketId+'&data='+json)
        .success(function() {
          refreshSelect(bracketId)
        })
    })

    refreshSelect(hash())

    $('#bracketSelect').change(function() {
      var value = $(this).val()
      location.hash = '#!'+value
      if (!value) {
        newBracket()
        return
      }
      $('#fields').empty()

      $.getJSON('rest.php?op=get&id='+value, function(data) {
        $('#editor').empty().bracket({
            init: data,
            save: function(data){
                var json = jQuery.toJSON(data)
                $('pre').text(jQuery.toJSON(data))
                $.getJSON('rest.php?op=set&id='+value+'&data='+json)
              }
          })
      }).error(function() { })
    })
  })
</script>