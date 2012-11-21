<% if Subjects.MoreThanOnePage %>
<p class="pagination">
        <% if Subjects.NotFirstPage %>
	<a href="$Subjects.PrevLink" class="prev">Prev</a>
        <% end_if %>

	<% control Subjects.Pages(9) %>
	<% if CurrentBool %>
	<span>$PageNum</span>
	<% else %>
	<a href="$Link">$PageNum</a>
	<% end_if %>
	<% end_control %>

	<% if Subjects.NotLastPage %>
	<a href="$Subjects.NextLink" class="next">Next</a>
    <% end_if %>
</p>
<% end_if %>