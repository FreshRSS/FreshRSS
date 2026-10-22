{{/*
Generate a name based on the release name and chart name.
*/}}
{{- define "name" -}}
{{- default .Chart.Name .Values.nameOverride | trunc 63 | trimSuffix "-" -}}
{{- end -}}

{{/*
Fully qualified app name used for resource names.
*/}}
{{- define "freshrss.fullname" -}}
{{- default .Release.Name .Values.fullnameOverride | trunc 63 | trimSuffix "-" -}}
{{- end -}}

{{/*
Name of the ServiceAccount to use.
*/}}
{{- define "freshrss.serviceAccountName" -}}
{{- if .Values.serviceAccount.create -}}
{{- default (include "freshrss.fullname" .) .Values.serviceAccount.name -}}
{{- else -}}
{{- default "default" .Values.serviceAccount.name -}}
{{- end -}}
{{- end -}}

