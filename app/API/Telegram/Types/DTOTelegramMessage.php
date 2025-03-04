<?php
/**
 * Create: Volodymyr
 */

namespace App\API\Telegram\Types;

use App\API\Common\Traits\DTOHelps;

class DTOTelegramMessage
{
    protected null|int $message_id = null;
    protected null|int $message_thread_id = null;
    protected null|int $sender_boost_count = null;
    protected null|int $date = null;
    protected null|int $edit_date = null;
    protected null|int $migrate_to_chat_id = null;
    protected null|int $migrate_from_chat_id = null;

    protected null|string $business_connection_id = null;
    protected null|string $media_group_id = null;
    protected null|string $author_signature = null;
    protected null|string $text = null;
    protected null|string $effect_id = null;
    protected null|string $caption = null;
    protected null|string $new_chat_title = null;
    protected null|string $connected_website = null;

    protected null|bool $is_topic_message = null;
    protected null|bool $is_automatic_forward = null;
    protected null|bool $has_protected_content = null;
    protected null|bool $is_from_offline = null;
    protected null|bool $show_caption_above_media = null;
    protected null|bool $has_media_spoiler = null;
    protected null|bool $delete_chat_photo = null;
    protected null|bool $group_chat_created = null;
    protected null|bool $supergroup_chat_created = null;
    protected null|bool $channel_chat_created = null;

    protected null|object|array $from = null;
    protected null|object|array $sender_chat = null;
    protected null|object|array $sender_business_bot = null;
    protected null|object|array $chat = null;
    protected null|object|array $forward_origin = null;
    protected null|object|array $reply_to_message = null;
    protected null|object|array $external_reply = null;
    protected null|object|array $quote = null;
    protected null|object|array $reply_to_story = null;
    protected null|object|array $via_bot = null;
    protected null|object|array $entities = null;
    protected null|object|array $link_preview_options = null;
    protected null|object|array $animation = null;
    protected null|object|array $audio = null;
    protected null|object|array $document = null;
    protected null|object|array $paid_media = null;
    protected null|object|array $photo = null;
    protected null|object|array $sticker = null;
    protected null|object|array $story = null;
    protected null|object|array $video = null;
    protected null|object|array $video_note = null;
    protected null|object|array $voice = null;
    protected null|object|array $caption_entities = null;
    protected null|object|array $contact = null;
    protected null|object|array $dice = null;
    protected null|object|array $game = null;
    protected null|object|array $poll = null;
    protected null|object|array $venue = null;
    protected null|object|array $location = null;
    protected null|object|array $new_chat_members = null;
    protected null|object|array $left_chat_member = null;
    protected null|object|array $new_chat_photo = null;
    protected null|object|array $message_auto_delete_timer_changed = null;
    protected null|object|array $pinned_message = null;
    protected null|object|array $invoice = null;
    protected null|object|array $successful_payment = null;
    protected null|object|array $refunded_payment = null;
    protected null|object|array $users_shared = null;
    protected null|object|array $chat_shared = null;
    protected null|object|array $write_access_allowed = null;
    protected null|object|array $passport_data = null;
    protected null|object|array $proximity_alert_triggered = null;
    protected null|object|array $boost_added = null;
    protected null|object|array $chat_background_set = null;
    protected null|object|array $forum_topic_created = null;
    protected null|object|array $forum_topic_edited = null;
    protected null|object|array $forum_topic_closed = null;
    protected null|object|array $forum_topic_reopened = null;
    protected null|object|array $general_forum_topic_hidden = null;
    protected null|object|array $general_forum_topic_unhidden = null;
    protected null|object|array $giveaway_created = null;
    protected null|object|array $giveaway = null;
    protected null|object|array $giveaway_winners = null;
    protected null|object|array $giveaway_completed = null;
    protected null|object|array $video_chat_scheduled = null;
    protected null|object|array $video_chat_started = null;
    protected null|object|array $video_chat_ended = null;
    protected null|object|array $video_chat_participants_invited = null;
    protected null|object|array $web_app_data = null;
    protected null|object|array $reply_markup = null;

    public function getMessageId(): ?int
    {
        return $this->message_id;
    }

    public function setMessageId(?int $message_id): static
    {
        $this->message_id = $message_id;
        return $this;
    }

    public function getMessageThreadId(): ?int
    {
        return $this->message_thread_id;
    }

    public function setMessageThreadId(?int $message_thread_id): static
    {
        $this->message_thread_id = $message_thread_id;
        return $this;
    }

    public function getSenderBoostCount(): ?int
    {
        return $this->sender_boost_count;
    }

    public function setSenderBoostCount(?int $sender_boost_count): static
    {
        $this->sender_boost_count = $sender_boost_count;
        return $this;
    }

    public function getDate(): ?int
    {
        return $this->date;
    }

    public function setDate(?int $date): static
    {
        $this->date = $date;
        return $this;
    }

    public function getEditDate(): ?int
    {
        return $this->edit_date;
    }

    public function setEditDate(?int $edit_date): static
    {
        $this->edit_date = $edit_date;
        return $this;
    }

    public function getMigrateToChatId(): ?int
    {
        return $this->migrate_to_chat_id;
    }

    public function setMigrateToChatId(?int $migrate_to_chat_id): static
    {
        $this->migrate_to_chat_id = $migrate_to_chat_id;
        return $this;
    }

    public function getMigrateFromChatId(): ?int
    {
        return $this->migrate_from_chat_id;
    }

    public function setMigrateFromChatId(?int $migrate_from_chat_id): static
    {
        $this->migrate_from_chat_id = $migrate_from_chat_id;
        return $this;
    }

    public function getBusinessConnectionId(): ?string
    {
        return $this->business_connection_id;
    }

    public function setBusinessConnectionId(?string $business_connection_id): static
    {
        $this->business_connection_id = $business_connection_id;
        return $this;
    }

    public function getMediaGroupId(): ?string
    {
        return $this->media_group_id;
    }

    public function setMediaGroupId(?string $media_group_id): static
    {
        $this->media_group_id = $media_group_id;
        return $this;
    }

    public function getAuthorSignature(): ?string
    {
        return $this->author_signature;
    }

    public function setAuthorSignature(?string $author_signature): static
    {
        $this->author_signature = $author_signature;
        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): static
    {
        $this->text = $text;
        return $this;
    }

    public function getEffectId(): ?string
    {
        return $this->effect_id;
    }

    public function setEffectId(?string $effect_id): static
    {
        $this->effect_id = $effect_id;
        return $this;
    }

    public function getCaption(): ?string
    {
        return $this->caption;
    }

    public function setCaption(?string $caption): static
    {
        $this->caption = $caption;
        return $this;
    }

    public function getNewChatTitle(): ?string
    {
        return $this->new_chat_title;
    }

    public function setNewChatTitle(?string $new_chat_title): static
    {
        $this->new_chat_title = $new_chat_title;
        return $this;
    }

    public function getConnectedWebsite(): ?string
    {
        return $this->connected_website;
    }

    public function setConnectedWebsite(?string $connected_website): static
    {
        $this->connected_website = $connected_website;
        return $this;
    }

    public function getIsTopicMessage(): ?bool
    {
        return $this->is_topic_message;
    }

    public function setIsTopicMessage(?bool $is_topic_message): static
    {
        $this->is_topic_message = $is_topic_message;
        return $this;
    }

    public function getIsAutomaticForward(): ?bool
    {
        return $this->is_automatic_forward;
    }

    public function setIsAutomaticForward(?bool $is_automatic_forward): static
    {
        $this->is_automatic_forward = $is_automatic_forward;
        return $this;
    }

    public function getHasProtectedContent(): ?bool
    {
        return $this->has_protected_content;
    }

    public function setHasProtectedContent(?bool $has_protected_content): static
    {
        $this->has_protected_content = $has_protected_content;
        return $this;
    }

    public function getIsFromOffline(): ?bool
    {
        return $this->is_from_offline;
    }

    public function setIsFromOffline(?bool $is_from_offline): static
    {
        $this->is_from_offline = $is_from_offline;
        return $this;
    }

    public function getShowCaptionAboveMedia(): ?bool
    {
        return $this->show_caption_above_media;
    }

    public function setShowCaptionAboveMedia(?bool $show_caption_above_media): static
    {
        $this->show_caption_above_media = $show_caption_above_media;
        return $this;
    }

    public function getHasMediaSpoiler(): ?bool
    {
        return $this->has_media_spoiler;
    }

    public function setHasMediaSpoiler(?bool $has_media_spoiler): static
    {
        $this->has_media_spoiler = $has_media_spoiler;
        return $this;
    }

    public function getDeleteChatPhoto(): ?bool
    {
        return $this->delete_chat_photo;
    }

    public function setDeleteChatPhoto(?bool $delete_chat_photo): static
    {
        $this->delete_chat_photo = $delete_chat_photo;
        return $this;
    }

    public function getGroupChatCreated(): ?bool
    {
        return $this->group_chat_created;
    }

    public function setGroupChatCreated(?bool $group_chat_created): static
    {
        $this->group_chat_created = $group_chat_created;
        return $this;
    }

    public function getSupergroupChatCreated(): ?bool
    {
        return $this->supergroup_chat_created;
    }

    public function setSupergroupChatCreated(?bool $supergroup_chat_created): static
    {
        $this->supergroup_chat_created = $supergroup_chat_created;
        return $this;
    }

    public function getChannelChatCreated(): ?bool
    {
        return $this->channel_chat_created;
    }

    public function setChannelChatCreated(?bool $channel_chat_created): static
    {
        $this->channel_chat_created = $channel_chat_created;
        return $this;
    }

    public function getFrom(): object|array|null
    {
        return $this->from;
    }

    public function setFrom(object|array|null $from): static
    {
        $this->from = $from;
        return $this;
    }

    public function getSenderChat(): object|array|null
    {
        return $this->sender_chat;
    }

    public function setSenderChat(object|array|null $sender_chat): static
    {
        $this->sender_chat = $sender_chat;
        return $this;
    }

    public function getSenderBusinessBot(): object|array|null
    {
        return $this->sender_business_bot;
    }

    public function setSenderBusinessBot(object|array|null $sender_business_bot): static
    {
        $this->sender_business_bot = $sender_business_bot;
        return $this;
    }

    public function getChat(): object|array|null
    {
        return $this->chat;
    }

    public function setChat(object|array|null $chat): static
    {
        $this->chat = $chat;
        return $this;
    }

    public function getForwardOrigin(): object|array|null
    {
        return $this->forward_origin;
    }

    public function setForwardOrigin(object|array|null $forward_origin): static
    {
        $this->forward_origin = $forward_origin;
        return $this;
    }

    public function getReplyToMessage(): object|array|null
    {
        return $this->reply_to_message;
    }

    public function setReplyToMessage(object|array|null $reply_to_message): static
    {
        $this->reply_to_message = $reply_to_message;
        return $this;
    }

    public function getExternalReply(): object|array|null
    {
        return $this->external_reply;
    }

    public function setExternalReply(object|array|null $external_reply): static
    {
        $this->external_reply = $external_reply;
        return $this;
    }

    public function getQuote(): object|array|null
    {
        return $this->quote;
    }

    public function setQuote(object|array|null $quote): static
    {
        $this->quote = $quote;
        return $this;
    }

    public function getReplyToStory(): object|array|null
    {
        return $this->reply_to_story;
    }

    public function setReplyToStory(object|array|null $reply_to_story): static
    {
        $this->reply_to_story = $reply_to_story;
        return $this;
    }

    public function getViaBot(): object|array|null
    {
        return $this->via_bot;
    }

    public function setViaBot(object|array|null $via_bot): static
    {
        $this->via_bot = $via_bot;
        return $this;
    }

    public function getEntities(): object|array|null
    {
        return $this->entities;
    }

    public function setEntities(object|array|null $entities): static
    {
        $this->entities = $entities;
        return $this;
    }

    public function getLinkPreviewOptions(): object|array|null
    {
        return $this->link_preview_options;
    }

    public function setLinkPreviewOptions(object|array|null $link_preview_options): static
    {
        $this->link_preview_options = $link_preview_options;
        return $this;
    }

    public function getAnimation(): object|array|null
    {
        return $this->animation;
    }

    public function setAnimation(object|array|null $animation): static
    {
        $this->animation = $animation;
        return $this;
    }

    public function getAudio(): object|array|null
    {
        return $this->audio;
    }

    public function setAudio(object|array|null $audio): static
    {
        $this->audio = $audio;
        return $this;
    }

    public function getDocument(): object|array|null
    {
        return $this->document;
    }

    public function setDocument(object|array|null $document): static
    {
        $this->document = $document;
        return $this;
    }

    public function getPaidMedia(): object|array|null
    {
        return $this->paid_media;
    }

    public function setPaidMedia(object|array|null $paid_media): static
    {
        $this->paid_media = $paid_media;
        return $this;
    }

    public function getPhoto(): object|array|null
    {
        return $this->photo;
    }

    public function setPhoto(object|array|null $photo): static
    {
        $this->photo = $photo;
        return $this;
    }

    public function getSticker(): object|array|null
    {
        return $this->sticker;
    }

    public function setSticker(object|array|null $sticker): static
    {
        $this->sticker = $sticker;
        return $this;
    }

    public function getStory(): object|array|null
    {
        return $this->story;
    }

    public function setStory(object|array|null $story): static
    {
        $this->story = $story;
        return $this;
    }

    public function getVideo(): object|array|null
    {
        return $this->video;
    }

    public function setVideo(object|array|null $video): static
    {
        $this->video = $video;
        return $this;
    }

    public function getVideoNote(): object|array|null
    {
        return $this->video_note;
    }

    public function setVideoNote(object|array|null $video_note): static
    {
        $this->video_note = $video_note;
        return $this;
    }

    public function getVoice(): object|array|null
    {
        return $this->voice;
    }

    public function setVoice(object|array|null $voice): static
    {
        $this->voice = $voice;
        return $this;
    }

    public function getCaptionEntities(): object|array|null
    {
        return $this->caption_entities;
    }

    public function setCaptionEntities(object|array|null $caption_entities): static
    {
        $this->caption_entities = $caption_entities;
        return $this;
    }

    public function getContact(): object|array|null
    {
        return $this->contact;
    }

    public function setContact(object|array|null $contact): static
    {
        $this->contact = $contact;
        return $this;
    }

    public function getDice(): object|array|null
    {
        return $this->dice;
    }

    public function setDice(object|array|null $dice): static
    {
        $this->dice = $dice;
        return $this;
    }

    public function getGame(): object|array|null
    {
        return $this->game;
    }

    public function setGame(object|array|null $game): static
    {
        $this->game = $game;
        return $this;
    }

    public function getPoll(): object|array|null
    {
        return $this->poll;
    }

    public function setPoll(object|array|null $poll): static
    {
        $this->poll = $poll;
        return $this;
    }

    public function getVenue(): object|array|null
    {
        return $this->venue;
    }

    public function setVenue(object|array|null $venue): static
    {
        $this->venue = $venue;
        return $this;
    }

    public function getLocation(): object|array|null
    {
        return $this->location;
    }

    public function setLocation(object|array|null $location): static
    {
        $this->location = $location;
        return $this;
    }

    public function getNewChatMembers(): object|array|null
    {
        return $this->new_chat_members;
    }

    public function setNewChatMembers(object|array|null $new_chat_members): static
    {
        $this->new_chat_members = $new_chat_members;
        return $this;
    }

    public function getLeftChatMember(): object|array|null
    {
        return $this->left_chat_member;
    }

    public function setLeftChatMember(object|array|null $left_chat_member): static
    {
        $this->left_chat_member = $left_chat_member;
        return $this;
    }

    public function getNewChatPhoto(): object|array|null
    {
        return $this->new_chat_photo;
    }

    public function setNewChatPhoto(object|array|null $new_chat_photo): static
    {
        $this->new_chat_photo = $new_chat_photo;
        return $this;
    }

    public function getMessageAutoDeleteTimerChanged(): object|array|null
    {
        return $this->message_auto_delete_timer_changed;
    }

    public function setMessageAutoDeleteTimerChanged(object|array|null $message_auto_delete_timer_changed): static
    {
        $this->message_auto_delete_timer_changed = $message_auto_delete_timer_changed;
        return $this;
    }

    public function getPinnedMessage(): object|array|null
    {
        return $this->pinned_message;
    }

    public function setPinnedMessage(object|array|null $pinned_message): static
    {
        $this->pinned_message = $pinned_message;
        return $this;
    }

    public function getInvoice(): object|array|null
    {
        return $this->invoice;
    }

    public function setInvoice(object|array|null $invoice): static
    {
        $this->invoice = $invoice;
        return $this;
    }

    public function getSuccessfulPayment(): object|array|null
    {
        return $this->successful_payment;
    }

    public function setSuccessfulPayment(object|array|null $successful_payment): static
    {
        $this->successful_payment = $successful_payment;
        return $this;
    }

    public function getRefundedPayment(): object|array|null
    {
        return $this->refunded_payment;
    }

    public function setRefundedPayment(object|array|null $refunded_payment): static
    {
        $this->refunded_payment = $refunded_payment;
        return $this;
    }

    public function getUsersShared(): object|array|null
    {
        return $this->users_shared;
    }

    public function setUsersShared(object|array|null $users_shared): static
    {
        $this->users_shared = $users_shared;
        return $this;
    }

    public function getChatShared(): object|array|null
    {
        return $this->chat_shared;
    }

    public function setChatShared(object|array|null $chat_shared): static
    {
        $this->chat_shared = $chat_shared;
        return $this;
    }

    public function getWriteAccessAllowed(): object|array|null
    {
        return $this->write_access_allowed;
    }

    public function setWriteAccessAllowed(object|array|null $write_access_allowed): static
    {
        $this->write_access_allowed = $write_access_allowed;
        return $this;
    }

    public function getPassportData(): object|array|null
    {
        return $this->passport_data;
    }

    public function setPassportData(object|array|null $passport_data): static
    {
        $this->passport_data = $passport_data;
        return $this;
    }

    public function getProximityAlertTriggered(): object|array|null
    {
        return $this->proximity_alert_triggered;
    }

    public function setProximityAlertTriggered(object|array|null $proximity_alert_triggered): static
    {
        $this->proximity_alert_triggered = $proximity_alert_triggered;
        return $this;
    }

    public function getBoostAdded(): object|array|null
    {
        return $this->boost_added;
    }

    public function setBoostAdded(object|array|null $boost_added): static
    {
        $this->boost_added = $boost_added;
        return $this;
    }

    public function getChatBackgroundSet(): object|array|null
    {
        return $this->chat_background_set;
    }

    public function setChatBackgroundSet(object|array|null $chat_background_set): static
    {
        $this->chat_background_set = $chat_background_set;
        return $this;
    }

    public function getForumTopicCreated(): object|array|null
    {
        return $this->forum_topic_created;
    }

    public function setForumTopicCreated(object|array|null $forum_topic_created): static
    {
        $this->forum_topic_created = $forum_topic_created;
        return $this;
    }

    public function getForumTopicEdited(): object|array|null
    {
        return $this->forum_topic_edited;
    }

    public function setForumTopicEdited(object|array|null $forum_topic_edited): static
    {
        $this->forum_topic_edited = $forum_topic_edited;
        return $this;
    }

    public function getForumTopicClosed(): object|array|null
    {
        return $this->forum_topic_closed;
    }

    public function setForumTopicClosed(object|array|null $forum_topic_closed): static
    {
        $this->forum_topic_closed = $forum_topic_closed;
        return $this;
    }

    public function getForumTopicReopened(): object|array|null
    {
        return $this->forum_topic_reopened;
    }

    public function setForumTopicReopened(object|array|null $forum_topic_reopened): static
    {
        $this->forum_topic_reopened = $forum_topic_reopened;
        return $this;
    }

    public function getGeneralForumTopicHidden(): object|array|null
    {
        return $this->general_forum_topic_hidden;
    }

    public function setGeneralForumTopicHidden(object|array|null $general_forum_topic_hidden): static
    {
        $this->general_forum_topic_hidden = $general_forum_topic_hidden;
        return $this;
    }

    public function getGeneralForumTopicUnhidden(): object|array|null
    {
        return $this->general_forum_topic_unhidden;
    }

    public function setGeneralForumTopicUnhidden(object|array|null $general_forum_topic_unhidden): static
    {
        $this->general_forum_topic_unhidden = $general_forum_topic_unhidden;
        return $this;
    }

    public function getGiveawayCreated(): object|array|null
    {
        return $this->giveaway_created;
    }

    public function setGiveawayCreated(object|array|null $giveaway_created): static
    {
        $this->giveaway_created = $giveaway_created;
        return $this;
    }

    public function getGiveaway(): object|array|null
    {
        return $this->giveaway;
    }

    public function setGiveaway(object|array|null $giveaway): static
    {
        $this->giveaway = $giveaway;
        return $this;
    }

    public function getGiveawayWinners(): object|array|null
    {
        return $this->giveaway_winners;
    }

    public function setGiveawayWinners(object|array|null $giveaway_winners): static
    {
        $this->giveaway_winners = $giveaway_winners;
        return $this;
    }

    public function getGiveawayCompleted(): object|array|null
    {
        return $this->giveaway_completed;
    }

    public function setGiveawayCompleted(object|array|null $giveaway_completed): static
    {
        $this->giveaway_completed = $giveaway_completed;
        return $this;
    }

    public function getVideoChatScheduled(): object|array|null
    {
        return $this->video_chat_scheduled;
    }

    public function setVideoChatScheduled(object|array|null $video_chat_scheduled): static
    {
        $this->video_chat_scheduled = $video_chat_scheduled;
        return $this;
    }

    public function getVideoChatStarted(): object|array|null
    {
        return $this->video_chat_started;
    }

    public function setVideoChatStarted(object|array|null $video_chat_started): static
    {
        $this->video_chat_started = $video_chat_started;
        return $this;
    }

    public function getVideoChatEnded(): object|array|null
    {
        return $this->video_chat_ended;
    }

    public function setVideoChatEnded(object|array|null $video_chat_ended): static
    {
        $this->video_chat_ended = $video_chat_ended;
        return $this;
    }

    public function getVideoChatParticipantsInvited(): object|array|null
    {
        return $this->video_chat_participants_invited;
    }

    public function setVideoChatParticipantsInvited(object|array|null $video_chat_participants_invited): static
    {
        $this->video_chat_participants_invited = $video_chat_participants_invited;
        return $this;
    }

    public function getWebAppData(): object|array|null
    {
        return $this->web_app_data;
    }

    public function setWebAppData(object|array|null $web_app_data): static
    {
        $this->web_app_data = $web_app_data;
        return $this;
    }

    public function getReplyMarkup(): object|array|null
    {
        return $this->reply_markup;
    }

    public function setReplyMarkup(object|array|null $reply_markup): static
    {
        $this->reply_markup = $reply_markup;
        return $this;
    }

}
