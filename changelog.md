# Changelog

## 1.13.1
- **FIX** Rename modifier table migration

## 1.13.0
- **ADD** `created_at` and `updated_at` fields in activity json resource

## 1.12.0
- **ADD** Activity Reminder `EmailTemplateSeed` seeder

## 1.11.0
- **ADD** endpoint _POST_ `/saved-searches` to save to `SavedSearches` resource

## 1.10.1
- **FIX** `ActivityStatuses` and `ActivityTypes` Enums are id index base of 1 now not 0

## 1.10.0
- **ADD** `deal_uuid` filter on GET /api/activity/v1/activities

## 1.9.0
- **ADD** listener for sent email and texts from other packages

## CLI
- **ADD** `fresh-activity:link`
- **ADD** `fresh-activity:seed`
- **ADD** `fresh-activity:version`

## 1.8.0
- **ADD** command, job, event, and listener to send notification to sales rep based on reminder settings

## 1.7.0
- **ADD** endpoint _PUT_ `/activities/{uuid}/notes` to update `text` in `NoteResource`

## 1.6.0
- **ADD** Add route to save activity `api/activity/v1/activities`

## 1.5.0
- **ADD** endpoint _PUT_ `/api/activity/v1/activities/{uuid}`

## 1.4.0
- **ADD** endpoint _POST_ `/api/activity/v1/activities/{uuid}/notes`

## 1.3.0
- **ADD** endpoint _GET_ `/api/activity/v1/activities/{uuid}`
- **ADD** model, migration, resource for Note
- **ADD** fields (`title`, `activity_reminder_quantity`, `activity_reminder_unity_id`) for model Activity

## 1.2.1
- **ADD** migration to remove foreign keys from activities table

## 1.2.0
- **ADD** endpoint _GET_ `/api/activity/v1/types`
- **ADD** endpoint _GET_ `/api/activity/v1/reminder-unities`

## 1.1.0
- **ADD** endpoint _GET_ `/api/activity/v1/activities` with filters `scheduled_at_after`, `scheduled_at_before`, `status_id`, `type_id`, `salesrep_uuid`,`customer_uuid`
- **ADD** endpoint _GET_ `/api/activitiy/v1/activities`
Sorting is enabled on the following fields: `status_id`, `scheduled_at`, `customer_email`, `type_name` and `salesrep_email`
- **ADD** endpoint _DELETE_ `/api/activity/v1/activity/{uuid}`
- **ADD** statuses list endpoint `/api/activity/v1/statuses`.
