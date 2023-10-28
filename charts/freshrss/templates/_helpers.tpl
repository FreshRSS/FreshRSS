{{/*
Generate a name based on the release name and chart name.
*/}}
{{- define "name" -}}
{{- default .Chart.Name .Release.Name -}}
{{- end -}}

# Data PVC name.
{{- define "freshrss.dataPVC" -}}
{{- if .Values.persistence.existingPVCName }}
{{- .Values.persistence.existingPVCName }}
{{- else }}
{{- .Release.Name }}-data
{{- end }}
{{- end }}