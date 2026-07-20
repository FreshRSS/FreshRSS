{{/*
Generate a name based on the release name and chart name.
*/}}
{{- define "name" -}}
{{- default .Chart.Name .Release.Name -}}
{{- end -}}

{{/*
Name of the ServiceAccount to use.
*/}}
{{- define "freshrss.serviceAccountName" -}}
{{- if .Values.serviceAccount.create -}}
{{- default .Release.Name .Values.serviceAccount.name -}}
{{- else -}}
{{- default "default" .Values.serviceAccount.name -}}
{{- end -}}
{{- end -}}

