<template>
	<div class="message"  :class="{'is-current-user': $root.currentUserLogin.id === message.user.id}">
		<div class="message-item user-name">
			{{ message.user.name}}
		</div>
		<div class="message-item timestamp">
			| {{ message.created_at }} : 
		</div>
		<div class="message-item text-message">
			{{ message.message }}
		</div>
	</div>
</template>

<script>
	export default {
		props : ['message']
	}
</script>

<style lang="scss">
	.message {
		display: flex;
		color: #00b8ff;
		.message-item:not(:last-child) {
			margin-right: 5px;
		}
	}
	.message:not(:last-child) {
		padding-bottom: 20px;
	}
	.is-current-user {
		color: #a900ff;
	}
</style>